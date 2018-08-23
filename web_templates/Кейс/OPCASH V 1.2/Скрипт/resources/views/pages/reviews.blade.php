@extends('layout')

@section('content')
    <main class="content">
        <div class="inner"><h1 class="title">Отзывы</h1>
            <div class="cls"></div><div class="static text-center"><!-- Put this script tag to the <head> of your page -->
<center><script type="text/javascript" src="//vk.com/js/api/openapi.js?141"></script>

<script type="text/javascript">
  VK.init({apiId: 5912603, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 20, width: "720", attach: false});
</script></center></div>
            <div class="cls"></div></div>
    </main>
@endsection
