// JavaScript Document
function code (bbcod)
{
document.guestform.text.value = document.guestform.text.value + '[' + bbcod + '][/' + bbcod + ']';
document.guestform.text.focus();
}
function admcode (admbbcod)
{
document.mainform.reply.value = document.mainform.reply.value + '[' + admbbcod + '][/' + admbbcod + ']';
document.mainform.reply.focus();
}