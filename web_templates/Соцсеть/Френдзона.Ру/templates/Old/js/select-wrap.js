window.onload = function() {

/* Объявление переменных. slct - массив тегов select страницы, L - их количество, i - счетчик циклов, tmp - контейнер для создаваемого тега */
var slct = document.getElementsByTagName('select'),
	L = slct.length,
	i, tmp;

/* Отключаем процесс для IE-8 */
if (window.navigator.userAgent.indexOf('IE 8') != -1) {L = 0;}

/* Перебираем select'ы, оборачиваем их в div с классом wselect и добавляем span с классом selecttext для вывода текста из select'а */
for (i = 0; i < L; i++) {
	tmp = document.createElement('div');
	tmp.className = 'wselect';
	slct[i].parentNode.insertBefore(tmp, slct[i]);
	tmp.appendChild(slct[i]);
	tmp.innerHTML = '<span class=\"selecttext\" id=\"selecttext' + i + '\"></span>' + tmp.innerHTML;
};

/* ---===Селекты обернуты и готовы к использованию===--- */

/* Создаем функцию, которая в селекте с индексом nn определяет активный option, берет из него текст и вставляет его в span с классом selecttext, после чего увеличивает счетчик (nn) на один и, если еще есть селекты с этим индексом, запускает сама себя, обрабатывая следующий select (таким образом перебираются все селекты страницы) */
function goSelect(nn, L) {
	myid = 'selecttext' + nn;
	fgm = 0;
for (i = 0; i < document.getElementsByTagName('select')[nn].options.length; i++) {
	if (document.getElementsByTagName('select')[nn].options[i].selected) {fgm = i;}
}
	document.getElementById(myid).innerHTML = document.getElementsByTagName('select')[nn].options[fgm].text;
	nn++;
	if (nn<L) {goSelect(nn, L)}
}

/* Функция, запускающая предыдущую со стартовым индексом nn = 0 */
function goSelectPlus(){
	goSelect(0, L);
}

/* И, наконец, функция, периодически запускающая предыдущую с интервалом 100 */
setInterval(goSelectPlus, 100);

}