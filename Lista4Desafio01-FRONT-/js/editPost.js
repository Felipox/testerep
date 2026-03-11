const token = localStorage.getItem('token');
const postId = localStorage.getItem('postIdClicado');

document.addEventListener('DOMContentLoaded', async () => {
    console.log("DEBUG: Carregando editPost.js versão ATUALIZADA");
    const res = await fetch(`http://127.0.0.1/api/posts/${postId}`, {
        headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    const data = await res.json();
    
    document.getElementById('edit-title').value = data.title;
    document.getElementById('edit-text').value = data.text;
    document.getElementById('form-edit-post').addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = document.getElementById('edit-title').value;
        const text = document.getElementById('edit-text').value;
    
        const res = await fetch(`http://127.0.0.1/api/posts/${postId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({title, text })
        });
    
        if (res.ok) {
            alert("Post atualizado!");
            window.location.href = 'posts.html';
        }
    });
});
