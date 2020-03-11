@extends('layouts.base')
@section('body')
    <div class="top-nav ">
        <div class="logo">
            <a href="{{route('admin.index')}}">easy-blog
            </a>
        </div>
        <div class="left_open">
            <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
        </div>
        <div class="left_open">您好，欢迎使用浩通科技CMS管理系统</div>
        <ul class="layui-nav right" lay-filter="">
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="layui-icon layui-icon-username">admin</i><span
                            class="layui-nav-more"></span></a>
                <dl class="layui-nav-child layui-anim layui-anim-upbit">
                    <!-- 二级菜单 -->
                    <dd>
                        <a href="javascript:logout()">修改密码</a></dd>
                    <dd>
                        <a href="javascript:logout()">注销账号</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item to-index">
                <a href="/"></a>
            </li>
        </ul>
    </div>
    @include('layouts.nav')
    @yield('content')
@endsection
@section('js')
    <script>
        layui.use('element', function () {
            var element = layui.element;
        });
    </script>
@endsection