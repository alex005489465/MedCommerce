import { defineStore } from 'pinia'
import { useIndexStore } from '.';

const indexStore = useIndexStore()
const baseurl = indexStore.getBaseURL

export const useUserStore = defineStore('user', {
    state: () => ({
        loginstatus: false,
        //username: '',
        email: '',
    }),
    persist: true,
    getters: {
        isLogin: (state) => state.loginstatus,
        //getUsername: (state) => state.username,
        getEmail: (state) => state.email,
    },
    actions: {
        async register(registerdata) {
            try {
                const response = await fetch(baseurl.concat('/register'), {
                        method: 'POST',
                        headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: registerdata.name,
                        email: registerdata.email,
                        password: registerdata.password,
                        password_confirmation: registerdata.password_confirmation
                    }),
                });

                if (response.status === 201) {
                    const data = await response.json();
                    if (data) {
                        this.loginstatus = true;
                        this.email = registerdata.email;
                    } else {
                        console.error('Empty or null response data');
                    }
                }
            } catch (error) {
                console.error('Error during registration:', error);
            }
        },
        async login(logindata) {
            try {
                const response = await fetch(baseurl.concat('/login'), {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(logindata),
                });

                if (response.status === 200) {
                    this.loginstatus = true;
                    //this.username = logindata.username;
                    this.email = logindata.email;
                } else {
                    throw new Error('Login failed');
                }
            } catch (error) {
            console.error('Error during login:', error);
            }
        },
        async logout() {
            try {
                const response = await fetch(baseurl.concat('/logout'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: null,
                });

                if (response.status === 204) {
                    this.loginstatus = false;
                    //this.username = '';
                    this.email = '';
                } else {
                    throw new Error('Logout failed');
                }
            } catch (error) {
                console.error('Error during logout:', error);
            }
        },
    },
})