import { LS_TOKEN_KEY } from "./constants";
import axiosInstance from "./http";

export default class TokenManager {
  token = null;

  setToken(token) {
    this.token = token;
    localStorage.setItem(LS_TOKEN_KEY, token);
    axiosInstance.defaults.headers["Authorization"] = `Bearer ${token}`;
  }

  logout() {
    this.token = null;
    localStorage.removeItem(LS_TOKEN_KEY);
    delete axiosInstance.defaults.headers["Authorization"];
  }

  renew() {
    const token = localStorage.getItem(LS_TOKEN_KEY);
    if (token != null) {
      this.setToken(token);
    }
  }

  getPayload() {
    if (this.token != null) {
      const parts = this.token.split(".");
      const rawData = atob(parts[1]);
      return JSON.parse(rawData);
    }
    return null;
  }

  isUserLogged() {
    return this.token != null;
  }
}
