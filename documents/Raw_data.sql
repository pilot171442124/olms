INSERT INTO `t_booktypes` (`BookTypeId`, `BookType`, `created_at`, `updated_at`) VALUES
(1, 'Hard Copy', NULL, NULL),
(2, 'Soft copy', NULL, NULL);


INSERT INTO `t_bookaccesstype` (`BookAccessTypeId`, `BookAccessType`, `created_at`, `updated_at`) VALUES
(1, 'Public', NULL, NULL),
(2, 'Private', NULL, NULL);

INSERT INTO `t_books` (`BookId`, `BookTypeId`, `BookName`, `AuthorName`, `TotalCopy`, `BookAccessTypeId`, `BookURL`, `Remarks`, `created_at`, `updated_at`) VALUES
(1, 2, 'English', 'Hasib', 22, 1, NULL, NULL, NULL, NULL),
(3, 2, 'Data structure', 'Balagul shami', 10, 1, 'bookfile/EX8IbfjcPWd3RmsJP7pb2XNRQcOQdT5McFdBhejn.xlsx', 'This is the remarks', NULL, NULL),
(5, 1, 'Bangla', 'Rubel', 5, 2, NULL, 'trett', NULL, NULL),
(6, 1, 'Islamic study', 'Mawlana', 454, 1, NULL, '343fdfdsf', NULL, NULL);


