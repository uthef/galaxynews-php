<?php
    class Article {
        private int $id;
        private string $title;
        private string $announce;
        private string $date;
        private string $imageUrl;
        private ?string $content = null;

        public function __construct(int $id, string $title, string $announce, string $date, string $imageUrl, ?string $content = null) {
            $this->id = $id;
            $this->title = $title;
            $this->announce = $announce;
            $this->date = $date;
            $this->imageUrl = $imageUrl;
            $this->content = $content;
        }

        public function getId(): int {
            return $this->id;
        }

        public function getTitle(): string {
            return $this->title;
        }

        public function getAnnounce(): string {
            return $this->announce;
        }

        public function getDate(): string {
            return date("d.m.Y", strtotime($this->date));
        }

        public function getImageUrl(): string {
            return $this->imageUrl;
        }

        public function getContent(): ?string {
            return $this->content;
        }
    }