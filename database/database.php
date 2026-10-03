<?php 
    require("models/article.php");
    require("models/index.php");

    class Database {
        private ?mysqli $mysqli = null;
        private int $NEWS_PORTION_SIZE = 4;

        public function connect(string $host, string $name, string $username, string $password, int $port) {
            if ($this->mysqli !== null) {
                $this->mysqli->close();
                $this->mysqli = null;
            }
            try {
                $this->mysqli = new mysqli($host, $username, $password, $name, $port);
            } catch (Exception $e) {
                die("Database exception: " . $e);
            }

            if ($this->mysqli->connect_error)
                die("Database connection failed: " . $this->mysqli->connect_error);

            // $this->createNewsTableIfNotExists();
        }

        public function countNews(): int {
            $this->dieIfNotConnected();
            $query_result = $this->mysqli->query("SELECT COUNT(*) FROM news");
            $row = $query_result->fetch_row();
            $query_result->close();

            if (count($row) != 1)
                return 0;

            return $row[0];
        }

        public function getLatestNews(int $page = 0): IndexModel {
            $this->dieIfNotConnected();
            $newsCount = $this->countNews();
            $totalPages = ceil($newsCount / $this->NEWS_PORTION_SIZE);
            $currentPage = min(max($page, 1), $totalPages);
            $offset = ($currentPage - 1) * $this->NEWS_PORTION_SIZE;

            $query_result = $this->mysqli->query("
                SELECT id, title, announce, `date`, image FROM news
                ORDER BY `date` DESC
                LIMIT $this->NEWS_PORTION_SIZE
                OFFSET $offset
            ");

            $articles = [];

            while ($row = $query_result->fetch_assoc()) {
                $article = $this->constructArticle($row);
                array_push($articles, $article);
            }

            $query_result->close();

            $model = new IndexModel($currentPage, $totalPages, $articles);
            return $model;
        }
 
        public function getArticle(int $id): Article | null {
            $this->dieIfNotConnected();

            $query_result = $this->mysqli->query("
                SELECT * FROM news
                WHERE id = $id
                LIMIT 1
            ");

            $row = $query_result->fetch_assoc();
            $article = null;

            if ($row)
                $article = $this->constructArticle($row);

            $query_result->close();
            return $article;
        }

        public function connectWithDefaultParams(): void {
            $this->connect(
                getenv("DB_HOST"), 
                getenv("DB_NAME"), 
                getenv("DB_USERNAME"), 
                getenv("DB_PASSWORD"), 
                getenv("DB_PORT")
            );
        }

        private function constructArticle(array $row): Article {
            return new Article(
                $row["id"],
                $row["title"],
                $row["announce"],
                $row["date"],
                "/static/images/attachments/" . $row["image"],
                $row["content"] ?? null
            );
        }

        private function dieIfNotConnected(): void {
            if ($this->mysqli == null || $this->mysqli->connect_error)
                die("Database connection is not established");
        }

        private function createNewsTableIfNotExists(): void {
            $this->dieIfNotConnected();
            $this->mysqli->query('
                CREATE TABLE IF NOT EXISTS "news" (
                    "id" bigint NOT NULL AUTO_INCREMENT,
                    "title" varchar(100) NOT NULL,
                    "announce" varchar(300) DEFAULT NULL,
                    "content" text NOT NULL,
                    "date" date NOT NULL,
                    "image" varchar(100) NOT NULL,
                    PRIMARY KEY ("id")
                );
            ');
        }
    }