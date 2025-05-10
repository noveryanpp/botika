import http from "../http-client";

class DivisionDataService {
  getAll() {
    return http.get("/divisions");
  }

  get(id) {
    return http.get(`/divisions/${id}`);
  }

  getByStatus(status) {
    return http.get(`/divisions?status=${status}`);
  }

  create(data) {
    return http.post("/divisions", data);
  }

  update(id, data) {
    return http.put(`/divisions/${id}`, data);
  }

  delete(id) {
    return http.delete(`/divisions/${id}`);
  }
}

export default new DivisionDataService();
