<script type="text/javascript" src="iframe_message_handler.js"></script>
<iframe id="test_iframe" name="test_iframe" src="http://localhost:8080/test_iframe">
</iframe>
<script>
var onMessage = function(message) {
    console.log('Message recieved from iframe: ' + JSON.stringify(message));
}
var dispatcher;
window.onload = function(){
    dispatcher = new MessagesDispatcher();
    dispatcher.init('http://localhost:8080', 'test_iframe');
    dispatcher.addMessageHandler(onMessage);
}
</script>
<input onclick="dispatcher.post({'content': 'a main frame message'})" type="submit"/>
