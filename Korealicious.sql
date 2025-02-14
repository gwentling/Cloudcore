-- Create Categories Table
CREATE TABLE Categories (
    category_id INTEGER PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL
);

-- Create Dishes Table
CREATE TABLE Dishes (
    dish_id INTEGER PRIMARY KEY,
    dish_name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(5,2),
    meal_type ENUM('Appetizer', 'Entree', 'Dessert', 'Drink') NOT NULL,
    category_id INTEGER,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
);

CREATE TABLE Users (
    user_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    role ENUM('Admin', 'Customer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Insert Categories
INSERT INTO Categories (category_id, category_name) VALUES
(1, 'Appetizers'),
(2, 'Entrees'),
(3, 'Desserts'),
(4, 'Drinks');

-- Insert Dishes
INSERT INTO Dishes (dish_id, dish_name, description, price, meal_type, category_id) VALUES
(1, 'Haemul Pa Jeon (Seafood Pancake)', 'Haemul Pa Jeon (해물파전) is an authentic Korean batter fried item, infused with scallions and assorted seafood (shrimp, squid, mussels, crab). Griddle fried to perfection.', 18.00, 'Appetizer', 1),
(2, 'Kimchi Jeon (Kimchi Pancake)', 'Kimchi Jeon (김치전) is a Korean tangy batter fried item suffused with shards of our very own kimchi. Enjoy deliciously crispy kimchi pancake as a snack or appetizer. Griddle fried to perfection.', 15.00, 'Appetizer', 1),
(3, 'Mandu', 'Everyone loves Mandu (만두), a very traditional menu item, 8 in each order. Choice of pork or veggie. Great for sharing. Served with our house Mandu sauce (간장) for dipping.', 16.00, 'Appetizer', 1),
(4, 'Bibimbap', 'One of our top sellers! Bibimbap (비빔밥) served in a fired Stone Bowl (Stone Bowl dine in only), warm white rice topped with sautéed and seasoned vegetables, gochujang (chili pepper paste), marinated beef, and a fried egg. Substitute tofu or chicken for the beef. Take out (Non Stone Bowl): $18.00.', 19.00, 'Entree', 2),
(5, 'Bibimbap Burrito', 'A Korealicious signature original. It''s a Bibimpap in a wrap! Available only before 3 pm. A Southwestern twist to our best selling dish. Rice, gochujang, marinated mixed vegetables, marinated beef, and a fried egg wrapped tightly in a herb and garlic tortilla. It''s HUGE! Substitute tofu or chicken for the beef.', 19.00, 'Entree', 2),
(6, 'Bulgogi', 'Our other top seller. Korean-style thinly sliced marinated beef with that distinct Korean flavor, served with rice. Add lettuce wraps and ssam jang (쌈장) ("full set"): $3.00 extra. Also, Chicken Bulgogi or Pork Bulgogi for same price. Add a little hot spice for a flavorful twist.', 21.00, 'Entree', 2),
(7, 'Spicy Stir Fry', 'Choice of chicken, pork (제육볶음), or tofu. Stir fried to perfection with our house-made signature spicy sauce, with sautéed assorted vegetables, served with a side of rice. Add lettuce wraps and ssam jang 쌈장 ("full set") for $3.00 extra. Add melted mozzarella and sticky rice barrels to the chicken stir fry for an additional charge.', 21.00, 'Entree', 2),
(8, 'Pork Belly', 'Pork belly is decadent stuff. Choice of spicy, kimchi, or regular sesame. Served with lettuce wraps, ssam jang 쌈장, and a healthy portion of white rice.', 24.00, 'Entree', 2),
(9, 'Japchae (Clear Noodle Stirfry)', 'Meaning “assorted vegetables,” this is a traditional savory favorite. Clear noodles made from sweet potato starch (dangmyeon) are stir-fried in sesame oil with beef and thinly sliced vegetables and seasoned with soy sauce and a touch of sweetness.', 19.00, 'Entree', 2),
(10, 'Stir Fried Noodles', 'Udon noodles, Korean style, stir fried with assorted vegetables. Sautéed and marinated in mom''s secret sauce for a hearty, noodle-like flavor explosion. Choice of beef, chicken, tofu, or veggie.', 19.00, 'Entree', 2),
(11, 'Korealicious Fried Rice', 'This is not your ordinary fried rice. You can never go wrong with our signature made-to-order fried rice, with an egg scrambled in. Add kimchi, chicken, shrimp, or tofu for $3.00 extra.', 16.00, 'Entree', 2),
(12, 'Yangnyum Chicken', 'Crispy seasoned boneless chicken chunks tossed in Mom''s amazingly addictive tangy hot sauce. We can adjust the spice level: no spice, mild, medium, spicy, and SUPER spicy.', 22.00, 'Entree', 2),
(13, 'Ddukbokki', 'Sticky rice barrels, fish cake, and vegetables bathed and simmered in our homemade spicy sauce. Add mandu (minimum 4 mandu) for an additional charge.', 16.00, 'Entree', 2),
(14, 'Sundubu Jjigae', 'Sundubu-jjigae (순두부찌개, 豆腐) or soft tofu stew is a jjigae (찌개, Korean stew) in Korean cuisine. The dish is made with freshly curdled soft tofu, beef brisket, fresh clams, vegetables, and spicy chili paste. Served with a side of white rice.', 18.00, 'Entree', 2),
(15, 'Kimchi Stew (Jjigae)', 'Kimchi stew is one of the most-loved of all the stews in Korean cuisine. Aged kimchi, pork, tofu, and other vegetables, served simmering with a healthy side of white rice.', 16.00, 'Entree', 2),
(16, 'Yukgaejang', 'Yukgaejang (육개장) or spicy beef soup is a spicy, soup-like Korean "stew" with shredded beef, scallions, shitake mushrooms, and other hearty ingredients, which are simmered to perfection. Comes with a hearty side of rice.', 19.00, 'Entree', 2),
(17, 'Ginseng Chicken', 'A whole tiny chicken simmered in a variety of vegetables, comfortably nestled on a bed of Korean rice, and stuff with rice, ginseng, and a secret treat.', 25.00, 'Entree', 2),
(18, 'Korealicious Wings', 'You get 8 luscious wings and/or drumettes. Flavors and sauces are all house originals. Flavor choices include sticky crunch pepper, spicy, sweet & spicy, or bulgogi.', 15.00, 'Appetizer', 1);

-- Insert Admin User Account
INSERT INTO Users (username, password, email, phone, first_name, last_name, role) VALUES
('admin_user', 'Password', 'admin@example.com', '123-456-7890', 'Admin', 'User', 'Admin');

-- Insert Fake Regular User Account (Dummy User)
INSERT INTO Users (username, password, email, phone, first_name, last_name, role) VALUES
('DummyUser', 'Dummy', 'dummyuser@example.com', '987-654-3210', 'Dummy', 'Customer', 'Customer');

