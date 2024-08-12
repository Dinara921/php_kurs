
document.addEventListener('DOMContentLoaded', function () {
    const loginBtn = document.getElementById('login-btn');
    const logoutBtn = document.getElementById('logout-btn');
    const emailInput = document.getElementById('kontakty_email');
    const passwordInput = document.getElementById('kontakty_password');
    const okno = document.getElementById('okno');

    const token = localStorage.getItem('authToken');
    if (token) {
        loginBtn.style.display = 'none';
        logoutBtn.style.display = 'block';
    } else {
        loginBtn.style.display = 'block';
        logoutBtn.style.display = 'none';
    }

    function login() {
        const email = emailInput.value;
        const password = passwordInput.value;

        if (!email || !password) {
            alert('Заполните все поля');
            return;
        }

        fetch('http://localhost:8080/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                password: password
            }),
        })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text); });
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                localStorage.setItem('authToken', data.token);
                loginBtn.style.display = 'none';
                logoutBtn.style.display = 'block';
                okno.style.display = 'none';
            })
            .catch(error => console.error('Ошибка:', error));
    }

    function logout() {
        localStorage.removeItem('authToken');
        loginBtn.style.display = 'block';
        logoutBtn.style.display = 'none';
    }

    loginBtn.addEventListener('click', function (event) {
        event.preventDefault();
        okno.style.display = 'block';
    });

    logoutBtn.addEventListener('click', function (event) {
        event.preventDefault();
        logout();
    });

    document.querySelector('#but').addEventListener('click', function () {
        login();
    });

    document.querySelector('.close').addEventListener('click', function (event) {
        event.preventDefault();
        okno.style.display = 'none';
    });
});
