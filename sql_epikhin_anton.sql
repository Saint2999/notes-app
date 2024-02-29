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

WITH count_table AS (
    SELECT 
        company, COUNT(id) AS trip_count 
    FROM Trip 
    GROUP BY company
),
min_trips AS (
    SELECT 
        MIN(trip_count) AS min_trip_count
    FROM count_table
)
DELETE
FROM Company 
WHERE Company.id IN (
    SELECT company
    FROM count_table
    JOIN min_trips
        ON count_table.trip_count = min_trips.min_trip_count
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