/**
 * Created by HP on 2016/12/13.
 */
function tip(msg,type,time){
    var div = $("#poptip");
    var content =$("#poptip_content");
    if(div.length<=0){
        div = $("<div id='poptip'></div>").appendTo(document.body);
        if(type!='success' && type!='danger'){
            type = 'success';
        }
        content =$("<div id='poptip_content' class='tip_"+type+"'>" + msg + "</div>").appendTo(document.body);
    }else{
        content.html(msg);
        content.show();
        div.show();
    }
    if(time) {
        time =  isNaN(time)? '2000' : time;
        setTimeout(function(){
            content.fadeOut(500);
            div.fadeOut(500);

        },time);
    }
}
function tip_close(){
    $("#poptip").fadeOut(500);
    $("#poptip_content").fadeOut(500);
}

$("#refresh").click(function(){
    window.location.reload();
})

$(".sure_add").click(function(){
    if($("#name_put").val() == ''){
        tip('请输入名字','danger',1000);
        return;
    }
    if($("#type_put").val() == '-1'){
        tip('请选择关系','danger',1000);
        return;
    }
    if($("#comming_put").val() == '-1'){
        tip('请选择状态','danger',1000);
        return;
    }
    var url = $("#add_user_form").attr('action');
    var reurl = $("#add_user_form").data('reurl');
    var data = $("#add_user_form").serialize();
    $.post(url,data,function(data){
        if(data.code==200){
            tip(data.msg,'success',1000);
            setTimeout(function(){
                window.location.href=reurl;
            },1000)
        }else{
            tip(data.msg,'danger',1000);
        }
    },'json')
})

$("#sel_comming").change(function(){
    var cancomming = $(this).val();
    var url        = $("#hide_url").val();
    url = url+"/cancomming/"+cancomming;
    window.location.href = url;
})

$("#sel_type").change(function(){
    var type = $(this).val();
    var url        = $("#hide_url").val();
    url = url+"/type/"+type;
    window.location.href = url;
})

$(".edit_user").click(function(){
    var id = $(this).data('id');
    $("#hide_edit_user_id").val(id);
    var url = $(this).data('url');
    url = url+"/id/"+id;
    $.getJSON(url,function(data){
        var html = data.msg;
        $("#editUser").modal('show');
        $("#editUser .modal-body").html(html);
    })
})
$(".sure_edit_user").click(function(){
    if($("#edit_name_put").val() == ''){
        tip('请输入名字','danger',1000);
        return;
    }
    if($("#edit_type_put").val() == '-1'){
        tip('请选择关系','danger',1000);
        return;
    }
    if($("#edit_comming_put").val() == '-1'){
        tip('请选择状态','danger',1000);
        return;
    }
    var url = $("#edit_user_form").attr('action');
    var reurl = $("#edit_user_form").data('reurl');
    var data = $("#edit_user_form").serialize();
    $.post(url,data,function(data){
        if(data.code==200){
            tip(data.msg,'success',1000);
            setTimeout(function(){
                window.location.href=reurl;
            },1000)
        }else{
            tip(data.msg,'danger',1000);
        }
    },'json')
})

$(".del_user").click(function(){
    var obj = this;
    if(confirm('确定移除么？')){
        var id = $(this).data('id');
        var url = $(this).data('url');
        url = url+"/id/"+id;
        $.getJSON(url,function(data){
            if(data.code != 200){
                tip('删除失败！','danger','1000');
            }else{
                tip(data.msg,'success','1000');
                $(obj).closest('.one_row').remove();
            }
        })
    }

})

$(function(){
    $(".comming").each(function(){
        var status = $(this).data('status');
        if(status == 0){
            //还在待定
            $(this).addClass('come0');
        }else if(status ==1){
            //可以
            $(this).addClass('come1');
        }else{
            $(this).addClass('come2');
        }
    })
})