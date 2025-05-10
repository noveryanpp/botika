import http from "../http-client";

class EmployeeDataService {
  login(data) {
    return http.post("/auth/login", data);
  }
}

export default new EmployeeDataService();
