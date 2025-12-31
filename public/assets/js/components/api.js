const API = {
    async getUsers() {
        const response = await fetch('/api/users');
        return response.json();
    },

    async createUser(data) {
        const response = await fetch('/api/users', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return response.json();
    }
};

// Exemplo de uso:
// API.getUsers().then(data => console.log(data));