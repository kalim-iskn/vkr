var value,mark,length,marks;
$(".calculating").change(function(){
    if($(this).val() != 0){
        $('#calculating_block').show();
        value = $('.'+$(this).val()).text();
        marks = (value.split('.')[0]).replace(/[^1-5]/g, '');
        mark = 0;
        var k = $.isNumeric(marks);
        if(k == true){
            length = marks.length-2;
            for(i = 0;i <= length;i++){
                mark = mark + parseInt(marks[i],10);
            };
            if(k == true && length+1 > 0)
                $("#average_mark").text((mark / (length+1)).toFixed(2));
            else
                $("#average_mark").text(" ");
            calculating();
        }else {
            length = -1;
            $("#average_mark").text(" ");
            calculating();
        }
    } else $('#calculating_block').hide();
});

$('#input_marks').bind("change keyup input click", function() {
    if (this.value.match(/[^1-5 ]/g)) {
        this.value = this.value.replace(/[^1-5 ]/g, '');
    }
});

$('#input_marks').bind("keyup input click keypress", function(){
    calculating();
});
///////////////////////////////CALCULATING////////////////////////////////////////////////////
function calculating(){
    var str = ($('#input_marks').val()).replace(/\s{0,}/g, '');
    var length_inp = length+1;
    var mark1 = mark;
    var j = 0;
    for(i = 0;i <= str.length-1;i++){
        mark1 = mark1 + parseInt(str[i],10);
        length_inp++;
        j++;
    }
    var k = isNaN(mark1 / length_inp);
    if(k != true && mark1 != 0) $("#average_mark").text((mark1 / length_inp).toFixed(2));
    else $("#average_mark").text(" ");
    $("#additional").text(j);
}
/////////////////////////////////////CALCULATING//////////////////////////////////////////////////////
