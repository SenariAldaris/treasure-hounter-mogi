window.onload = function() {

/* ���������� ����������. slct - ������ ����� select ��������, L - �� ����������, i - ������� ������, tmp - ��������� ��� ������������ ���� */
var slct = document.getElementsByTagName('select'),
	L = slct.length,
	i, tmp;

/* ��������� ������� ��� IE-8 */
if (window.navigator.userAgent.indexOf('IE 8') != -1) {L = 0;}

/* ���������� select'�, ����������� �� � div � ������� wselect � ��������� span � ������� selecttext ��� ������ ������ �� select'� */
for (i = 0; i < L; i++) {
	tmp = document.createElement('div');
	tmp.className = 'wselect';
	slct[i].parentNode.insertBefore(tmp, slct[i]);
	tmp.appendChild(slct[i]);
	tmp.innerHTML = '<span class=\"selecttext\" id=\"selecttext' + i + '\"></span>' + tmp.innerHTML;
};

/* ---===������� �������� � ������ � �������������===--- */

/* ������� �������, ������� � ������� � �������� nn ���������� �������� option, ����� �� ���� ����� � ��������� ��� � span � ������� selecttext, ����� ���� ����������� ������� (nn) �� ���� �, ���� ��� ���� ������� � ���� ��������, ��������� ���� ����, ����������� ��������� select (����� ������� ������������ ��� ������� ��������) */
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

/* �������, ����������� ���������� �� ��������� �������� nn = 0 */
function goSelectPlus(){
	goSelect(0, L);
}

/* �, �������, �������, ������������ ����������� ���������� � ���������� 100 */
setInterval(goSelectPlus, 100);

}