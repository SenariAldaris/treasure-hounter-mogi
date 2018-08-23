function ListCtrl($scope, Items, Data) {
  $scope.items = Items.query(function(data){
    var i = 0;
    angular.forEach(data, function(v,k) { data[k]._id = i++; });
  });
  $scope.categories = Data('categories');
  $scope.answerers  = Data('answerers');

  $scope.tablehead = [
    {name:'title',    title:"Заголовок"},
    {name:'category', title:"Категория"},
    {name:'answerer', title:"Кому задан"},
    {name:'author',   title:"Автор"},
    {name:'created',  title:"Задан"},
    {name:'answered', title:"Отвечен"},
    {name:'shown',    title:"Опубликован"}
  ];

  $scope.disableItem = function() {
    var item = this.item;
    Items.toggle({id:item.id}, function() { if (data.ok) item.shown = item.shown>0?0:1; });
  };
}