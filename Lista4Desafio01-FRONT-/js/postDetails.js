const token = localStorage.getItem('token');
const postId = localStorage.getItem('postIdClicado');
const meuId = localStorage.getItem('userId');

document.addEventListener('DOMContentLoaded', async function() {
    const postContainer = document.getElementById('post-container');
    const commentsContainer = document.getElementById('comments-container');

    const answer = await fetch(`http://127.0.0.1/api/posts/${postId}`, {
        headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    const data = await answer.json();

    if (answer.status === 200) {
        postContainer.innerHTML = `<h2>${data.title}</h2><p>${data.text}</p>`;
        
        commentsContainer.innerHTML = '';
        if (data.comments) {
            data.comments.forEach(coment => {
                const commentDiv = document.createElement('div');
                const btnExcluir = (coment.author_id === meuId) ? 
                    `<button onclick="excluirComentario('${coment.id}')">Excluir</button>` : '';

                commentDiv.innerHTML = `<p>${coment.text}</p>${btnExcluir}<hr>`;
                commentsContainer.appendChild(commentDiv);
            });
        }
    }
    document.getElementById('form-comentario')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = document.getElementById('texto-comentario').value;
        const res = await fetch(`http://127.0.0.1/api/posts/${postId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({ text })
        });
        if (res.ok) location.reload();
    });
});


async function excluirComentario(id) {
    if (!confirm("Excluir comentário?")) return;
    await fetch(`http://127.0.0.1/api/comments/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${token}` }
    });
    location.reload();
}