</main>

<footer class="bg-gray-800 text-white p-4 mt-10 text-center">
    &copy; <?= date('Y') ?> Ekskul Online. All rights reserved.
</footer>

<!-- Chatbot FAQ Widget -->
<div id="chatbot" class="fixed bottom-4 right-4 w-80 bg-white border shadow-lg rounded p-4 mb-4">
    <h3 class="font-bold mb-2">Chatbot FAQ</h3>
    <div id="chatbox" class="h-40 overflow-y-auto border p-2 mb-2"></div>
    <input type="text" id="chat_input" class="w-full border p-2 rounded" placeholder="Tanya FAQ...">
</div>

<!-- Virtual Assistant AI Widget -->
<div id="virtual_assistant" class="fixed bottom-4 right-4 w-80 bg-white border shadow-lg rounded p-4 mt-48">
    <h3 class="font-bold mb-2">Virtual Assistant</h3>
    <div id="va_chatbox" class="h-40 overflow-y-auto border p-2 mb-2"></div>
    <input type="text" id="va_input" class="w-full border p-2 rounded" placeholder="Tanya apa saja...">
</div>

<script>
// Chatbot FAQ
const chatbox = document.getElementById('chatbox');
const chatInput = document.getElementById('chat_input');
chatInput.addEventListener('keypress', function(e){
    if(e.key==='Enter'){
        const msg = chatInput.value.trim();
        if(msg==='') return;
        chatbox.innerHTML += '<div class="text-right text-blue-600">'+msg+'</div>';
        chatInput.value = '';
        fetch('/ekskul/chatbot',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'message='+encodeURIComponent(msg)
        }).then(res=>res.json()).then(data=>{
            chatbox.innerHTML += '<div class="text-left text-gray-700">'+data.response+'</div>';
            chatbox.scrollTop = chatbox.scrollHeight;
        });
    }
});

// Virtual Assistant AI
const va_chatbox = document.getElementById('va_chatbox');
const va_input = document.getElementById('va_input');
va_input.addEventListener('keypress', function(e){
    if(e.key==='Enter'){
        const msg = va_input.value.trim();
        if(msg==='') return;
        va_chatbox.innerHTML += '<div class="text-right text-blue-600">'+msg+'</div>';
        va_input.value = '';
        fetch('/ekskul/virtual-assistant',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'message='+encodeURIComponent(msg)
        }).then(res=>res.json()).then(data=>{
            va_chatbox.innerHTML += '<div class="text-left text-gray-700">'+data.response+'</div>';
            va_chatbox.scrollTop = va_chatbox.scrollHeight;
        });
    }
});
</script>

</body>
</html>
