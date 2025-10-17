import axios from "axios";
import { useAuth } from "@/stores";

const baseURL = import.meta.env.VITE_API_BASE_URL;

const axiosInstance = axios.create({
    baseURL: baseURL+"/api/v1",
});

axiosInstance.interceptors.request.use(function (config) {
    // Do something before request is sent
    const authInfo = useAuth();

    const auth = authInfo.user.meta ? `Bearer ${authInfo.user.meta.token}` : "";
   // alert(auth);
  //  config.defaults.headers.common["Authorization"] = auth;
    config.headers["Authorization"] = auth;
    return config;
  }, function (error) {
    // Do something with request error
    return Promise.reject(error);
});

export default axiosInstance;
