<?php
/**
 * AITool Model
 */
class AITool {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(string $search = '', ?int $limit = null, ?int $offset = null): array {
        $sql = "SELECT * FROM ai_tools";
        $params = [];

        if ($search !== '') {
            $sql .= " WHERE nama_ai LIKE :search OR developer LIKE :search OR kategori LIKE :search";
            $params['search'] = "%$search%";
        }

        $sql .= " ORDER BY id DESC";

        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        if ($limit !== null && $offset !== null) {
            $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count(string $search = ''): int {
        $sql = "SELECT COUNT(*) FROM ai_tools";
        $params = [];

        if ($search !== '') {
            $sql .= " WHERE nama_ai LIKE :search OR developer LIKE :search OR kategori LIKE :search";
            $params['search'] = "%$search%";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM ai_tools WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ? $result : null;
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO ai_tools (nama_ai, developer, kategori, website, deskripsi, status) VALUES (:nama_ai, :developer, :kategori, :website, :deskripsi, :status)");
        return $stmt->execute([
            'nama_ai' => $data['nama_ai'],
            'developer' => $data['developer'],
            'kategori' => $data['kategori'],
            'website' => $data['website'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'status' => $data['status'] ?? 'aktif'
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("UPDATE ai_tools SET nama_ai = :nama_ai, developer = :developer, kategori = :kategori, website = :website, deskripsi = :deskripsi, status = :status WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nama_ai' => $data['nama_ai'],
            'developer' => $data['developer'],
            'kategori' => $data['kategori'],
            'website' => $data['website'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'status' => $data['status'] ?? 'aktif'
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM ai_tools WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
