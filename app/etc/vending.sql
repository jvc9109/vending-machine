CREATE TABLE `vending_items`
(
    `id`     char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `name`   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `price`  float                                   NOT NULL,
    `status` int                                     NOT NULL,
    `stock`  int                                     NOT NULL,
    `created_on`         datetime                                NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    `updated_on`         datetime                                NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `vending_coin_counters`
(
    `id`          char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
    `coin_value`  float                               NOT NULL,
    `total_coins` int                                 NOT NULL,
    `created_on`         datetime                                NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    `updated_on`         datetime                                NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
