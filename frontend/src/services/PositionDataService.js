import http from "../http-client";

class PositionDataService {
  getAll() {
    return http.get("/positions");
  }

  get(id) {
    return http.get(`/positions/${id}`);
  }

  getByStatus(status) {
    return http.get(`/positions?status=${status}`);
  }

  create(data) {
    return http.post("/positions", data);
  }

  update(id, data) {
    return http.put(`/positions/${id}`, data);
  }

  delete(id) {
    return http.delete(`/positions/${id}`);
  }
}

export default new PositionDataService();
