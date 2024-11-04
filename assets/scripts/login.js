document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        await loginUser();
    });
});

async function loginUser() {
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (response.ok) {
            console.log('Login successful!', data);
            document.getElementById('error-alert').style.display = 'none';
            document.getElementById('success-alert').innerText = data.message;
            document.getElementById('success-alert').style.display = 'block';
            window.location.reload();
        } else {
            console.error('Login failed:', data.error);
            document.getElementById('error-alert').innerText = data.error;
            document.getElementById('error-alert').style.display = 'block';
        }
    } catch (error) {
        console.error('Network error:', error);
        document.getElementById('error-alert').innerText = 'Network error: ' + error.message;
        document.getElementById('error-alert').style.display = 'block';
    }
}
