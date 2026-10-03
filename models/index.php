<?php
    class IndexModel {
        private int $currentPage = 0;
        private int $totalPages = 0;
        public array $articles = [];

        public function __construct(int $currentPage, int $totalPages, array $articles) {
            $this->currentPage = $currentPage;
            $this->totalPages = $totalPages;
            $this->articles = $articles;
        }

        public function getCurrentPage(): int {
            return $this->currentPage;
        }

        public function getTotalPages(): int {
            return $this->totalPages;
        }
    }