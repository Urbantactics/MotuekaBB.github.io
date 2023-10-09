-- Create the motueka database if it doesn't exist
CREATE DATABASE IF NOT EXISTS motueka;
USE motueka;

-- The rooms for the bed and breakfast
DROP TABLE IF EXISTS Rooms;
CREATE TABLE IF NOT EXISTS Rooms (
    RoomID INT AUTO_INCREMENT PRIMARY KEY,
    RoomName VARCHAR(100) NOT NULL,
    Description TEXT DEFAULT NULL,
    RoomType CHARACTER DEFAULT 'D',
    Beds INT
) AUTO_INCREMENT=1;

-- Insert sample data into the Rooms table
INSERT INTO Rooms (RoomName, Description, RoomType, Beds) VALUES
    ('Anaru', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing', 'S', 5),
    ('Herman', 'Lorem ipsum dolor sit amet, consectetuer', 'D', 5);
    -- Add more room data here...

-- Customers
DROP TABLE IF EXISTS Customers;
CREATE TABLE IF NOT EXISTS Customers (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Password VARCHAR(40) NOT NULL DEFAULT '.'
) AUTO_INCREMENT=1;

-- Insert sample data into the Customers table
INSERT INTO Customers (FirstName, LastName, Email) VALUES
    ('Desiree', 'Collier', 'Desiree@non.co.uk'),
    ('Irene', 'Walker', 'irenewalker4u@id.org');
    -- Add more customer data here...

-- Bookings table
DROP TABLE IF EXISTS Bookings;
CREATE TABLE IF NOT EXISTS Bookings (
    BookingID INT AUTO_INCREMENT PRIMARY KEY,
    GuestsDetails VARCHAR(255),
    CheckInDate DATE NOT NULL,
    CheckOutDate DATE NOT NULL,
    RoomDetails VARCHAR(255) NOT NULL,
    SpecialRequirements TEXT,
    CancellationPolicy TEXT,
    PaymentMethod VARCHAR(50),
    TotalCost DECIMAL(10, 2) CHECK (TotalCost >= 0),
    RoomID INT,
    CustomerID INT,
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID),
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID),
    CHECK (CheckInDate < CheckOutDate)
);

-- Sample data for Bookings table
INSERT INTO Bookings (GuestsDetails, CheckInDate, CheckOutDate, RoomDetails, SpecialRequirements, CancellationPolicy, PaymentMethod, TotalCost, RoomID, CustomerID)
VALUES
    ('Jason and Kyah kaa', '2023-09-10', '2023-09-15', 'Double Room', 'None', 'Standard policy', 'Credit Card', 500.00, 1, 1),
    ('Ariki Johnson', '2023-10-05', '2023-10-10', 'Single Room', 'Early check-in required', 'Flexible policy', 'PayPal', 400.00, 2, 2);
