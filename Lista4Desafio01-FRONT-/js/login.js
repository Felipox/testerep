const formLogin = document.getElementById('form-register');

formLogin.addEventListener('submit', async function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const answer = await fetch('http://127.0.0.1/api/auth/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await answer.json();

        if (answer.status === 200) {
            localStorage.setItem('token', data.access_token);

            const userRes = await fetch('http://127.0.0.1/api/me', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${data.access_token}`,
                    'Accept': 'application/json'
                }
            });
            const userData = await userRes.json();
            localStorage.setItem('userId', userData.id);

            alert('Login efetuado com sucesso!');
            window.location.href = 'posts.html';
        } else {
            alert('Erro no login: Verifique suas credenciais.');
        }
    } catch (erro) {
        console.error(erro);
    }
});