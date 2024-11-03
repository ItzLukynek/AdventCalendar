document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        await loginUser();
    });
});
// log in the user
async function loginUser() {
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    const csrfToken = document.getElementById('csrf_token').value;

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                password: password,
                _csrf_token: csrfToken,
            }),
        });

        const responseText = await response.text();

        try {
            const data = JSON.parse(responseText);

            if (response.ok) {
                console.log('Login successful!', data);
                window.location.reload();
            } else {
                console.error('Login failed:', data.error || data);
                alert('Login failed: ' + (data.error || 'Unknown error'));
            }
        } catch (jsonError) {
            // JSON parse failed, log the HTML response
            console.error('Failed to parse JSON:', responseText);
        }
    } catch (error) {
        console.error('Network error:', error);
    }
}
