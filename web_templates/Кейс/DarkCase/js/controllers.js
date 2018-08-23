function ListCtrl($scope, Items, Data) {
  $scope.items = Items.query(function(data){
    var i = 0;
    angular.forEach(data, function(v,k) { data[k]._id = i++; });
  });
  $scope.categories = Data('categories');
  $scope.answerers  = Data('answerers');

  $scope.tablehead = [
    {name:'title',    title:"���������"},
    {name:'category', title:"���������"},
    {name:'answerer', title:"���� �����"},
    {name:'author',   title:"�����"},
    {name:'created',  title:"�����"},
    {name:'answered', title:"�������"},
    {name:'shown',    title:"�����������"}
  ];

  $scope.disableItem = function() {
    var item = this.item;
    Items.toggle({id:item.id}, function() { if (data.ok) item.shown = item.shown>0?0:1; });
  };
}