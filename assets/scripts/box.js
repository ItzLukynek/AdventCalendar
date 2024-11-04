//function for activating a box for a user
async function addBox(boxId) {
    try {
        const response = await fetch(`/api/activate-box/${boxId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            let errorMessage;

            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                const errorData = await response.json();
                errorMessage = errorData.error || 'Failed to activate the box.';
            } else {
                const errorText = await response.text();
                errorMessage = `Unexpected response format: ${errorText}`;
            }

            throw new Error(errorMessage);
        }

        const data = await response.json();

        console.log(data.message);
        console.log('Activated Box IDs:', data.activatedBoxIds);
        document.querySelector(`.box-${boxId}`).innerHTML = "✔️";

    } catch (error) {
        console.error('Error:', error.message);
    }
}

window.addBox = addBox