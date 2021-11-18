$(function(){
    $(".box-chat-online").scrollTop($(".box-chat-online")[0].scrollHeight);

    $("textarea").keyup(function (e){
        let code = e.keyCode || e.which;
        if(code == 13){
            insert_chat();
        }
    })

    $("form").submit(function(){
        insert_chat();
        return false;
    })
    function insert_chat(){
        let mensagem = $("textarea").val();
        $("textarea").val("");
        $.ajax({
            url:include_path+"ajax/chat.php",
            method:"post",
            data: {"mensagem":mensagem, "insert":true}
        }).done(function(data){
            $(".box-chat-online").append(data);
            $(".box-chat-online").scrollTop($(".box-chat-online")[0].scrollHeight);
        })
    }

    function get_messages(){
        $.ajax({
            url:include_path+'ajax/chat.php',
            method:"post",
            data:{"get_messages":true}
        }).done(function(data){
            $(".box-chat-online").append(data);
            $(".box-chat-online").scrollTop($(".box-chat-online")[0].scrollHeight);
        })
    }

    setInterval(function(){
        get_messages();
    }, 3000);
})