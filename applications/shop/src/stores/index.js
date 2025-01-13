import { defineStore } from 'pinia'

export const useIndexStore = defineStore('index', {
    state: () => ({
        apibaseURL: 'http://127.0.0.1:8000',
    }),
    getters: {
        getBaseURL: (state) => state.apibaseURL,
    },
    actions: {
        async start() {
            try {
                const response = await fetch(this.apibaseURL.concat('/'), {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });
                await response.json();
            } catch (error) {
                console.error('Error fetching from API:', error);
                throw error;
            }
        }
    },
})
