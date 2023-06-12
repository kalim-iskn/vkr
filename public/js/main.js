var timerId;
$(".username").bind("onchange keyup input", function()
{
    var k = 1;
    clearInterval(timerId);
    timerId = setInterval(function() {
  k++;
  if(k>1) {
      ajax_address();
      clearInterval(timerId);
  }
}, 1000);
});
function ajax_address(){
//Проверить существует ли имя
$.post("https://rt-client.tk/fl/scripts/address_availability.php",{ user_name:$(".username").val() } ,function(data)
{
if(data=='no') //если имя не доступно
{
$(".diss").prop( "disabled", true );
$("#msgbox").html('<br><br>Данный адрес занят!').addClass('messageboxerror');
}
else if(data == 'yes')
{
$(".diss").prop( "disabled", false);
$("#msgbox").html("");
}
else if(data == 'address'){
    $(".diss").prop( "disabled", false);
    $("#msgbox").html("<br><br>Адрес уже принадлежит Вам");
}
});
};
$('.username').bind("change keyup input click", function() {
    check_address()
});
function check_address(){
    pattern = /^[a-z][a-z0-9]*?([_][a-z0-9]+){0,6}$/i;
    var text = $(".username").val();
    if(pattern.test(text) === false || (text[0].toLowerCase() == "i" && text[1].toLowerCase() == "d" && /^\d+$/.test(text.substring(2)) == true)) {
        $("#alert_span").html("<br><br>В адресе разрешены: латинские буквы, цифры, знаки подчеркивания не более шести раз<br>Адрес должен начинаться с буквы и заканчиваться цифрой или буквой");
        $(".diss").prop( "disabled", true );
    }
    else {
        if(text.length >= 3 && text.length <= 20){
        $("#alert_span").html("");
        $(".diss").prop( "disabled", false );
        }
        else {
            $("#alert_span").html("<br><br>Минимальный размер адреса 3 символа, максимальный 20 символов");
            $(".diss").prop( "disabled", true );
        }
    }
}