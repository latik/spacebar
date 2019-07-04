-- Adminer 4.6.2 PostgreSQL dump

CREATE TABLE "article" (
    "id"             integer                NOT NULL,
    "title"          character varying(255) NOT NULL,
    "slug"           character varying(100) NOT NULL,
    "content"        text,
    "published_at"   timestamp(0),
    "author"         character varying(255) NOT NULL,
    "heart_count"    integer                NOT NULL,
    "image_filename" character varying(255),
    "created_at"     timestamp(0)           NOT NULL,
    "updated_at"     timestamp(0)           NOT NULL,
    CONSTRAINT "article_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "uniq_23a0e66989d9b62" UNIQUE ("slug")
) WITH (oids = false);


CREATE TABLE "article_tag" (
    "article_id" integer NOT NULL,
    "tag_id"     integer NOT NULL,
    CONSTRAINT "article_tag_pkey" PRIMARY KEY ("article_id", "tag_id"),
    CONSTRAINT "fk_919694f97294869c" FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "fk_919694f9bad26311" FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE
) WITH (oids = false);
CREATE INDEX "idx_919694f97294869c" ON "article_tag" USING btree ("article_id");
CREATE INDEX "idx_919694f9bad26311" ON "article_tag" USING btree ("tag_id");

CREATE TABLE "comment" (
    "id"          integer                NOT NULL,
    "article_id"  integer                NOT NULL,
    "author_name" character varying(255) NOT NULL,
    "content"     text                   NOT NULL,
    "is_deleted"  boolean                NOT NULL,
    "created_at"  timestamp(0)           NOT NULL,
    "updated_at"  timestamp(0)           NOT NULL,
    CONSTRAINT "comment_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "fk_9474526c7294869c" FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE
) WITH (oids = false);
CREATE INDEX "idx_9474526c7294869c" ON "comment" USING btree ("article_id");


CREATE TABLE "tag" (
    "id"         integer                NOT NULL,
    "name"       character varying(255) NOT NULL,
    "slug"       character varying(255) NOT NULL,
    "created_at" timestamp(0)           NOT NULL,
    "updated_at" timestamp(0)           NOT NULL,
    CONSTRAINT "tag_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "uniq_389b783989d9b62" UNIQUE ("slug")
) WITH (oids = false);


CREATE TABLE "user" (
    "id"       integer                NOT NULL,
    "email"    character varying(180) NOT NULL,
    "roles"    json                   NOT NULL,
    "password" character varying(255) NOT NULL,
    CONSTRAINT "uniq_8d93d649e7927c74" UNIQUE ("email"),
    CONSTRAINT "user_pkey" PRIMARY KEY ("id")
) WITH (oids = false);
