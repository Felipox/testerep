const token = localStorage.getItem('token');

if(!token)
{
    window.location.href = 'index.html';
}

const formRegister = document.getElementById('form-create-post');

formRegister.addEventListener('submit', async function(event){
    event.preventDefault();

    const title = document.getElementById('title').value;
    const text = document.getElementById('content').value;

    const answer = await fetch('http://127.0.0.1/api/posts',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', 
            'Authorization': `Bearer ${token}`,
        },
        body: JSON.stringify({
                title: title,
                content: text,
        })
    });
    const data = await answer.json();

    if(answer.status === 201 || answer.status === 200)
    {
        alert("Conteudo postado com sucesso!");
        window.location.href = 'posts.html';
    }
    else{
        console.log("Erro:", data);
        alert("Erro ao publicar");
    }
})