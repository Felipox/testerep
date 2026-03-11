const token = localStorage.getItem('token');
const meuId = localStorage.getItem('userId');

if (!token) window.location.href = 'index.html';

document.addEventListener('DOMContentLoaded', async function() {
    const container = document.getElementById('container-posts');
    
    const answer = await fetch('http://127.0.0.1/api/posts', {
        headers: { 
            'Authorization': `Bearer ${token}`, 
            'Accept': 'application/json' 
        }
    });
    
    const data = await answer.json();
    container.innerHTML = '';

    if (answer.status === 200) {
        data.forEach(post => {
            const postElement = document.createElement('div');
            
            const botoesAutor = (post.author_id === meuId) ? `
                <button onclick="irParaEditar('${post.id}')">Editar</button>
                <button onclick="arquivarPost('${post.id}')">Arquivar</button>
                <button onclick="deletarPost('${post.id}')" style="color: red;">Excluir</button>
            ` : '';

            postElement.innerHTML = `
                <h3>${post.title}</h3>
                <p>${post.text}</p>
                ${botoesAutor}
                <button onclick="verPost('${post.id}')">Ver Comentários</button>
                <hr>
            `;
            container.appendChild(postElement);
        });
    } else {
        alert('Erro ao listar posts');
    }
});
function verPost(id) {
    localStorage.setItem('postIdClicado', id);
    window.location.href = 'postDetails.html';
}

function irParaEditar(id) {
    localStorage.setItem('postIdClicado', id);
    window.location.href = 'editPost.html';
}

async function arquivarPost(id) {
    if (!confirm("Deseja arquivar este post?")) return;
    const res = await fetch(`http://127.0.0.1/api/posts/${id}/archive`, {
        method: 'PATCH',
        headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
    });
    if (res.ok) {
        alert("Post arquivado!");
        location.reload();
    }
}

async function deletarPost(id) {
    if (!confirm("TEM CERTEZA? Isso vai apagar o post para sempre!")) return;
    
    const res = await fetch(`http://127.0.0.1/api/posts/${id}`, {
        method: 'DELETE',
        headers: { 
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        }
    });

    if (res.ok) {
        alert("Post excluído com sucesso!");
        location.reload();
    } else {
        alert("Erro ao excluir o post.");
    }
}

async function fazerLogout() {
    try {
        const response = await fetch('http://127.0.0.1/api/auth/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        localStorage.removeItem('token');
        localStorage.removeItem('userId');
        window.location.href = 'index.html';
        
    } catch (error) {
        console.error('Erro no logout:', error);
        localStorage.clear();
        window.location.href = 'index.html';
    }
}