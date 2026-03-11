const formRegister = document.getElementById('form-register');

formRegister.addEventListener('submit', async function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    
        const answer = await fetch('http://127.0.0.1/api/auth/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                email: email,
                password: password,
            })
        });

        const data = await answer.json();
        console.log(data);

        if (answer.status === 201) {
            alert('Usuário criado com sucesso!');
            
            window.location.href = 'login.html';

        } else
        {
            alert('Erro no cadastro');
        }
});