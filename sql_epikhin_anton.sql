-- ##Задача 1

SELECT 
    MAX(TIMESTAMPDIFF(YEAR, Student.birthday, NOW())) AS max_year 
FROM Student 
JOIN Student_in_class 
    ON Student.id = Student_in_class.student 
JOIN Class 
    ON Student_in_class.class = Class.id 
        AND Class.name LIKE '10%';


-- ##Задача 2

DELETE 
FROM Company 
WHERE Company.id IN (
    SELECT company 
    FROM Trip 
    GROUP BY company 
    HAVING COUNT(id) = (
        SELECT MIN(trip_count) 
        FROM (
            SELECT COUNT(id) AS trip_count 
            FROM Trip 
            GROUP BY company
        ) AS count_table
    )
);


-- ##Задача 3

SELECT ROUND(
    (
        SELECT COUNT(*) 
        FROM (
            SELECT DISTINCT Reservations.user_id 
            FROM Reservations 
            UNION 
            SELECT DISTINCT Rooms.owner_id 
            FROM Rooms 
            JOIN Reservations 
                ON Rooms.id = Reservations.room_id
        )  AS active_users
    ) / (
        SELECT COUNT(id) 
        FROM Users
    ) * 100, 
    2
) AS percent; 