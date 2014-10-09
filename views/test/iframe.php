<script type="text/javascript" src="iframe_message_handler.js"></script>
<script>
var onMessage = function(message) {
    console.log('Message recieved from main frame: ' + JSON.stringify(message));
}
var dispatcher;
window.onload = function(){
    dispatcher = new MessagesDispatcher();
    dispatcher.init('http://localhost:8080', 'parent');
    dispatcher.addMessageHandler(onMessage);
}
</script>
<input onclick="dispatcher.post({'content': 'an iframe message'})" type="submit"/>
