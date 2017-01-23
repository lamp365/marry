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

$("#sel_iscomming").change(function(){
    var iscomming = $(this).val();
    var url        = $("#hide_url").val();
    url = url+"/iscomming/"+iscomming;
    window.location.href = url;
})

$("#sel_type").change(function(){
    var type = $(this).val();
    var url        = $("#hide_url").val();
    url = url+"/type/"+type;
    window.location.href = url;
})
$("#sel_hotal").change(function(){
    var hotal = $(this).val();
    var url        = $("#hide_url").val();
    url = url+"/hotal/"+hotal;
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

$(".edit_iscomming").click(function(){
    var obj = this;
    var status = $(this).data('status');
    if(status == 0){
        status = 1;
    }else{
        status = 0;
    }
    var url  = $(this).data('url');
    var id  = $(this).data('id');
    $.post(url,{'iscomming':status,'id':id},function(data){
        tip(data.msg,'success',1000);
        if(status == 1){
            $(obj).data('status',1);
            $(obj).removeClass('btn-danger');
            $(obj).addClass('btn-warning');
            $(obj).html('已签到');
        }else{
            $(obj).data('status',0);
            $(obj).removeClass('btn-warning');
            $(obj).addClass('btn-danger');
            $(obj).html('未签到');
        }
    },'json')
})

function countDown(time,id){
    var end_time = time * 1000,//月份是实际月份-1
        sys_second = (end_time-new Date().getTime())/1000;
    console.log(end_time);
    getTime(sys_second,id);
    var timer = setInterval(function(){
        if (sys_second > 1) {
            sys_second -= 1;
            getTime(sys_second,id);
        } else {
            clearInterval(timer);
        }
    }, 1000);
}
function getTime(sys_second,id){
    var day = Math.floor((sys_second / 3600) / 24);
    var hour = Math.floor((sys_second / 3600) % 24);
    var minute = Math.floor((sys_second / 60) % 60);
    var second = Math.floor(sys_second % 60);
    if($(id+' .limit_d')){
        $(id+' .limit_d').text(day<10?"0"+day:day);
    }
    if( second <=0 && minute<=0 ){
        $(id).html("结束");
    }
    $(id+' .limit_h').text(hour<10?"0"+hour:hour);    //计算小时
    $(id+' .limit_m').text(minute<10?"0"+minute:minute); //计算分钟
    $(id+' .limit_s').text(second<10?"0"+second:second); //计算秒
}

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

    $(".edit_iscomming").each(function(){
        var status = $(this).data('status');
        if(status == 0){
            //未签到
            $(this).addClass('btn-danger');
        }else if(status ==1){
            //已签到
            $(this).addClass('btn-warning');
        }
    })

    $(window).scroll(function(){    //这个是滚动的
        var distanceTop = 600;

        if  ($(window).scrollTop() > distanceTop)
            $(".foot_fix_top").show();
        else
            $(".foot_fix_top").hide();
    });
    $(".foot_fix_top").click(function(){
        $("html,body").animate({scrollTop: 0},"slow");
    })

})

$(".need_hotal span").click(function(){
    var id     = $(this).data('id');
    var hotal  = $(this).data('hotal');
    var url    = $(this).data('url');
    var obj    = this;
    if(hotal == 1){
        $.post(url,{'id':id,'hotal':2},function(data){
            tip(data.msg,'success',1000);
            $(obj).data('hotal',2);
            $(obj).removeClass('btn-default');
            $(obj).addClass('btn-info');
            $(obj).html('需要住宿');
        },'json')
    }else{
        $.post(url,{'id':id,'hotal':1},function(data){
            tip(data.msg,'success',1000);
            $(obj).data('hotal',1);
            $(obj).removeClass('btn-info');
            $(obj).addClass('btn-default');
            $(obj).html('无需住宿');
        },'json')
    }
})

$(".hongbao").blur(function(){
    var id      = $(this).data('id');
    var hongbao = $(this).val();
    var url     = $(this).data('url');
    $.post(url,{'id':id,'hongbao':hongbao},function(data){
        tip(data.msg,'success',500);
    },'json')
})