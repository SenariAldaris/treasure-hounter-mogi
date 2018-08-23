@extends('admin.layout')

@section('content')

<div class="navbar navbar-inverse" id="nav" style="display: block;">

    <!-- Main Navigation: Inner -->
    <div class="navbar-inner">

        <form class="navbar-search pull-right" action="/admin/searchusers">
            <input type="text" name="name" class="search-query" placeholder="Поиск login" autocomplete="off">
        </form>
        <form class="navbar-search pull-right" action="/admin/searchusersname">
            <input type="text" name="name" class="search-query" placeholder="Поиск name" autocomplete="off">
        </form>

    </div>
    <!-- / Main Navigation: Inner -->

</div>

<style>td {
        white-space: nowrap;
        word-wrap: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }</style>


<div class="top-bar">
    <h3>Пользователи</h3>

</div>


<div class="well no-padding">

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Ник</th>
            <th>Login</th>
            <th>Баланс</th>
            <th>Админ</th>
            <th>Youtuber</th>
        </tr>
        </thead>
        <tbody>


        @foreach($users as $i)


        <tr>
            <td>{{$i->id}}</td>
            <td>{{$i->username}}</td>
            <td>{{$i->login}}</td>
            <td>{{$i->money}}</td>
            <td>@if($i->is_admin)<span class="label label-important">Да</span>@else <span class="label label-success">Нет</span>
                @endif
            </td>
            <td>@if($i->is_yt)<span class="label label-important">Да</span>@else <span class="label label-success">Нет</span>
                @endif
            </td>
            <td><a href="/admin/givemoney/{{$i->id}}" class="btn btn-info">Перевести деньги</a></td>
            <td><a href="/admin/user/{{$i->id}}">Редактировать</a></td>
        </tr>
	
        @endforeach

        </tbody>
    </table>
			<div class="filters">
			<div class="inner">
			<div class="right">
			<ul class="pagination">
			<li><a href="http://webcash.top/admin/users/?page=1">1</a></li>
			<li><a href="http://webcash.top/admin/users/?page=2">2</a></li>
			<li><a href="http://webcash.top/admin/users/?page=3">3</a></li>
			<li><a href="http://webcash.top/admin/users/?page=4">4</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=5">5</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=6">6</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=7">7</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=8">8</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=9">9</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=10">10</a></li>
			<li><a href="http://webcash.top/admin/users/?page=11">11</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=12">12</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=13">13</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=14">14</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=15">15</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=16">16</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=17">17</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=18">18</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=19">19</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=20">20</a></li>
			<li><a href="http://webcash.top/admin/users/?page=21">21</a></li>
			<li><a href="http://webcash.top/admin/users/?page=22">22</a></li>
			<li><a href="http://webcash.top/admin/users/?page=23">23</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=24">24</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=25">25</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=26">26</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=27">27</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=28">28</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=29">29</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=30">30</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=31">31</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=32">32</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=33">33</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=34">34</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=35">35</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=36">36</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=37">37</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=38">38</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=39">39</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=40">40</a></li>
            <li><a href="http://webcash.top/admin/users/?page=41">41</a></li>
			<li><a href="http://webcash.top/admin/users/?page=42">42</a></li>
			<li><a href="http://webcash.top/admin/users/?page=43">43</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=44">44</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=45">45</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=46">46</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=47">47</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=48">48</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=49">49</a></li> 
			<li><a href="http://webcash.top/admin/users/?page=50">50</a></li> 
			</ul>
			</div>
			<div class="cls"></div>
			</div>
			</div>
    {{$users->render()}}
    <!-- / Add News: WYSIWYG Edior -->

</div>
<!-- / Add News: Content -->

</div>

</div>


@endsection
