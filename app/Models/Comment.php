<?php
/**
 * Created by PhpStorm.
 * @Author: ChenDasheng
 * @Created: 2020/4/8
 * Time: 0:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use App\Models\SocialiteUser;
class Comment extends Model
{
    use SoftDeletes,Cachable;
    protected $table = 'comments';
    protected $fillable = ['socialite_user_id', 'type', 'pid', 'article_id','is_audited','content','content'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    // 用于递归
    private $child = [];

    public function socialiteUser()
    {
        return $this->belongsTo(SocialiteUser::class)->withDefault();
    }
    public function getDataByArticleId($article_id)
    {
        // 关联第三方用户表获取一级评论
        $data = $this->select('comments.*', 'ou.name', 'ou.avatar', 'ou.is_admin')
            ->join('socialite_users as ou', 'comments.socialite_user_id', 'ou.id')
            ->where('comments.article_id', $article_id)
            ->where('comments.pid', 0)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        foreach ($data as $k => $v) {
            $data[$k]['content'] = htmlspecialchars_decode($v['content']);

            // 获取二级评论
            $this->child = [];
            $this->getTree($v);

            if (!empty($child = $this->child)) {
                // 按评论时间asc排序
                uasort($child, function ($a, $b) {
                    $prev = $a['created_at'] ?? 0;
                    $next = $b['created_at'] ?? 0;

                    if ($prev == $next) {
                        return 0;
                    }

                    return ($prev < $next) ? -1 : 1;
                });

                foreach ($child as $m => $n) {
                    // 获取被评论人id
                    $replyUserId = $this->where('id', $n['pid'])->pluck('socialite_user_id');

                    // 获取被评论人昵称
                    $child[$m]['reply_name'] = SocialiteUser::where([
                        'id' => $replyUserId,
                    ])->value('name');
                }
            }

            $data[$k]['child'] = $child;
        }

        return $data;
    }

    // 递归获取树状结构
    public function getTree($data)
    {
        $child = $this
            ->select('comments.*', 'ou.name', 'ou.avatar', 'ou.is_admin')
            ->join('socialite_users as ou', 'comments.socialite_user_id', 'ou.id', 'ou.is_admin')
            ->where('comments.pid', $data['id'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        if (!empty($child)) {
            foreach ($child as $k => $v) {
                $v['content']  = htmlspecialchars_decode($v['content']);
                $this->child[] = $v;
                $this->getTree($v);
            }
        }

    }


}