import axios from 'axios';

const apiService = axios.create({
  baseURL: 'http://127.0.0.1:8000',
  // You can set other Axios configurations here, such as headers or timeouts.
});

// Add an interceptor to attach the JWT token to each request.
apiService.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token'); // Retrieve the token from storage.
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export default apiService;