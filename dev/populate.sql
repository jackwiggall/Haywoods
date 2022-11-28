USE 22ac3d03;
-- Product
INSERT INTO Product (sku_code, name, description, price, image_count)
VALUES (
        110001,
        'Round Chestnut Coffee Table',
        'This round chestnut coffee table is all the new rage, making any living space look modern and chic perfect for slotting into a room corner or front and centre for you and your visitors',
        23.99,
        1
    ),
    (
        110002,
        'Round Oak Coffee Table',
        'This round oak coffee table is the sibling to our chestnut table in stock, a brighter shade making for a less cosy more energetic feel to your living room',
        25.99,
        1
    ),
    (
        110003,
        'Rectangle Ash Coffee Table',
        'Looking for a rustic touch? This rectangular ash coffee table is exactly what you need, it’s a fantastic centrepiece and talking point for your living room with its colour complimentary to most colour schemes',
        30.99,
        1
    ),
    (
        110004,
        'Triangle White Coffee Table',
        'No abundance of space but still looking for a modern touch? This white triangular coffee table is for you, the design allows it to easily tuck away into the corner of the room and its lightweight material makes it easy to move around at your leisure',
        19.99,
        1
    ),
    (
        120001,
        'Oak Dining Table',
        'The must have for this season, oak wood dining table is sleek stylish and spacious enough for the biggest of fajita nights able to sit two small households with ease, this product is also perfect for displaying nibbles during a house party',
        89.99,
        1
    ),
    (
        120002,
        'Large granite Dining Table',
        'This unique design is just the talking point you need for your dining area, with a square design symmetry is easy meaning all fans of the oddly satisfying way of life are satisfied indeed',
        95.95,
        1
    ),
    (
        120003,
        'Medium Mahogany Dining Table',
        'When looking to show off, impress a prince perhaps? Then this dining table is putting money where your mouth is, it’s expensive, it’s big, It is MAHOGANY!',
        595.99,
        1
    ),
    (
        120004,
        'Medium Marble Dining Table',
        'Make Rome jealous with this marble dining table, it will fit any dinner party guests or family members you could want! Be warned though, with a table this glamourous, you will need to keep your eyes peeled for thieves wanting to get their hands on this',
        112.00,
        2
    ),
    (
        210001,
        'Medium Canvas Sofa',
        'It’s comfy, it\'s practical, it’s designed for you! This grey canvas sofa is great for cuddling up and watching TV and is designed specifically to go with some of our coffee table range!',
        89.95,
        1
    ),
    (
        210002,
        'Medium Felt Sofa',
        'Grey not your style? Want something to make that living room pop? Then why not green? It’s loud, it’s colourful, it’s playful, it’s the talking point you will love!',
        77.99,
        1
    ),
    (
        210003,
        'Large Leather Sofa',
        'Do you like clubs? Yeah you do! This red leather sofa will make your room look like the VIP at the most exclusive club in town, the paparazzi will be at your door as soon as you place it in the house, party of 1 or party of 30 all that’s needed is some good music!',
        121.95,
        1
    ),
    (
        210004,
        'Medium Leather Sofa',
        'A nice cosy addition to the family home, movie night or warm mugs of hot chocolate, perfect from log cabins in the mountains to a penthouse in the big city!',
        146.99,
        1
    ),
    (
        220001,
        'Gaming Office Chair',
        'Struggling to get a win with your friends? Then you definitely need a better gaming chair, watch that K/D skyrocket and open a PO box just to store all of those Esport contracts that will be flying in your direction!',
        87.99,
        1
    ),
    (
        220002,
        'Reception Office Chair',
        'Bring a whole new meaning to home office, by bringing office to the home, this office chair is up to the standard of the offices in the city and with its comfort you are going to be left wondering why you ever bothered with that morning commute!',
        79.95,
        1
    ),
    (
        220003,
        'Home Office Chair',
        'Sick of having a crooked back from sitting at a desk all day? This office chair mixes pure comfort with practicality, the ergonomic mesh back will help fix your posture and reduce back pain guarunteed!',
        99.99,
        1
    ),
    (
        220004,
        'Sofa Office Chair',
        'Spend a lot of time at a desk? Playing games and watching movies, working and sitting. Then bring the living room to your bedroom with this sofa turned office chair. Ultimate comfort ultimate productivity',
        112.45,
        1
    ),
    (
        310001,
        'King Oak Bedframe',
        'Sweet dreams are guaranteed with this king size oak bed frame that will leave you feeling like royalty, plenty of storage space underneath the frame, this simple but effective look is perfect for decorating your bedroom around, it’s like a blank canvas!',
        359.99,
        1
    ),
    (
        310002,
        'Queen Chestnut Bedframe',
        'This queen size divan bed is sleek, stylish and comfort guaranteed, with the divan style under bed storage is kept masked leaving your room looking organised and well kept, not to mention the size of the bed allowing you to take up as much space as you need for your beauty sleep!',
        688.99,
        1
    ),
    (
        310003,
        'Double Grey Bedframe',
        'Modern design is very popular and this bed is an example of why this is the case. With its sleek design, padded headboard and tones to match most modern decor it looks great and feels great!',
        296.99,
        1
    ),
    (
        310004,
        'Single Oak Bedframe',
        'This item of pure luxury is just what anyone could ask for in their bedroom, it is almost magical with its powers to send anyone to sleep in seconds allowing them to wake up at the crack of dawn feeling refreshed and ready to tackle the day. This bed speaks for itself',
        1000.00,
        1
    ),
    (
        320001,
        'Dark Oak Wardrobe',
        'Dark colours are the in for interior design and this wardrobe is the perfect product for this, it is built tall to bring a new style of storage, fitting in the smallest of rooms but not sacrificing space with two racks for storing clothing on hangers plus the drawer space underneath, leaving more space for you!',
        299.99,
        1
    ),
    (
        320002,
        'White Mirrored Wardrobe',
        'Who doesn’t like to turn their bedroom into a personal catwalk whilst getting ready, whether it is for work, uni or a night out with friends this mirrored wardrobe lets you sass walk to your heart\'s content whilst picking out the perfect fit for your day!',
        315.95,
        1
    ),
    (
        330001,
        'Oak Chest of Drawers',
        'No bedroom is complete without a chest of drawers for your clothes, this oak drawer set has 6 drawers for organisation not to mention the space on top for ornaments or even doubling as a night stand!',
        210.99,
        1
    ),
    (
        330002,
        'White Chest of Drawers',
        'Looking for a more whitewashed style? Then these white chest of drawers are the one for you. With a wider design giving you more space per drawer for all the shopaholics out there who need a place for all their clothing hauls!',
        175.95,
        1
    );
-- Review
INSERT INTO Review (sku_code, rating, title, content, review_date)
VALUES (
        110004,
        7,
        'Good value for money',
        'My flatmate and I purchased this item around 3 weeks ago to furnish our new home. The table does the job and has a nice white colour giving it a modern look! One fallback however is the size of the table but with it being the cheapest on the site that\'s to be expected.',
        '2022/04/12 22:14:36'
    ),
    (
        220003,
        10,
        'Exactly what I was looking for!',
        'As I work from home I have been looking for a chair to support me better and found this absolute beauty! The quality of this product justifies its price tag and feels like it has practically cured my back pain I used to previously experience. Brilliant!',
        '2022/05/03 15:30:22'
    ),
    (
        120004,
        2,
        'Awful. Just awful!',
        'Since retiring I decided to do some home improvement with the money I had just gotten from my pension. I thought it would be a good idea to splash on a more expensive dining table. I was wrong! The material feels so cheap and has already been chipped after only 4 days. I will NEVER shop here again!',
        '2021/12/26 08:00:48'
    ),
    (
        220003,
        8,
        'Great product!',
        '',
        '2020/04/30 22:17:08'
    ),
    (
        120003,
        8,
        'Bravo!',
        'Thy knights and doth search by many moons for a table for tha round one hath fallen and crumbled. The Kings gold bestowed upon thee welleth spent. LONG LIVE THE KING!',
        '2020/06/02 06:00:03'
    ),
    (
        210003,
        1,
        'Absolute SCAM!',
        'I am not sure if I was sent the wrong product but this is not what I ordered from the photo! The sofa isn\'t even red, it\'s BLUE and can barely sit 2 people let alone 3.',
        '2021/10/12 14:58:32'
    ),
    (
        310004,
        10,
        'Perfection!',
        'I do not know what divine powers were used to make this bed but I never want to use another one again! It is incredibly comfy and I have never slept so well in my life, it is like it takes me 3 seconds to sleep and I instantly time travel to sunrise feeling refreshed! I would give a higher rating if it was possible!',
        '2020/03/08 19:53:11'
    ),
    (
        330001,
        7,
        'Nice addition to a room',
        'My wife and I were re-decorating our son\'s room and purchased this wardrobe to match the room\'s colours. It could do with being a little bigger and having more storage for clothes but is overall decent for the price.',
        '2022/07/18 17:42:36'
    ),
    (
        220001,
        6,
        'Too overpriced',
        'Although this product is good and does the job, it is not worth the price tag that comes with it.',
        '2021/09/11 16:25:14'
    ),
    (
        210002,
        9,
        'Super comfy!',
        '',
        '2020/08/27 12:14:29'
    ),
    (
        310002,
        4,
        '',
        '',
        '2019/07/11 15:12:38'
    ),
    (
        110004,
        6,
        '',
        '',
        '2020/05/01 10:56:35'
    ),
    (
        220002,
        2,
        '',
        '',
        '2021/11/04 09:31:15'
    ),
    (
        120003,
        9,
        '',
        '',
        '2019/10/03 07:46:42'
    ),
    (
        220004,
        4,
        '',
        '',
        '2019/12/22 19:03:41'
    ),
    (
        310002,
        8,
        '',
        '',
        '2021/03/08 14:51:37'
    ),
    (
        320001,
        1,
        '',
        '',
        '2020/06/17 12:40:26'
    ),
    (
        210003,
        5,
        '',
        '',
        '2022/12/09 20:37:18'
    );
-- AccessLevel
INSERT INTO AccessLevel(accessLevel_id, name)
VALUES (1, 'Management'),
    (2, 'Supervisor'),
    (3, 'Employee'),
    (4, 'Trainee');
-- Store
INSERT INTO Store(store_id, location)
VALUES (1, '19 Annfield Street Dundee'),
    (2, '51 Kellier Road Edinburgh'),
    (3, '44 Hawthorn Road Perth'),
    (
        4,
        '3 Kinning Park Industrial Estate Glasgow'
    );
-- Staff
INSERT INTO Staff (
        store_id,
        accessLevel_id,
        firstname,
        lastname,
        pay,
        address,
        contactNumber,
        contractedHours,
        login_username,
        login_password
    )
VALUES (
        1,
        1,
        'Michael',
        'Mathews',
        6.83,
        '69 Matthews Avenue Perth',
        '07541335195',
        16,
        'micms',
        'pass'
    ),
    (
        1,
        2,
        'Elliot',
        'Scott',
        8.45,
        '12 Matthews Road Montrose',
        '079876432143',
        20,
        'ellst',
        'pass'
    ),
    (
        1,
        3,
        'Benjamin',
        'Duguid',
        11.24,
        '18 Barnes Street Aberdeen',
        '07554125685',
        30,
        'bendd',
        'pass'
    ),
    (
        1,
        4,
        'Chris',
        'O\'May',
        10.25,
        '2 Cecil Street Stirling',
        '07754121873',
        26,
        'chroy',
        'pass'
    ),
    (
        1,
        3,
        'Nicole',
        'Jackson',
        11.24,
        '17 Andrews Crescent Perth',
        '07748156684',
        38,
        'nicjn',
        'pass'
    ),
    (
        1,
        4,
        'Jack',
        'Wiggall',
        10.25,
        '7 Craigstown Road Dunfermline',
        '07845125463',
        16,
        'jacwl',
        'pass'
    ),
    (
        1,
        1,
        'Jonathan',
        'Deer',
        6.83,
        '54 Perth Road Dundee',
        '07451365259',
        12,
        'jondr',
        'pass'
    ),
    (
        1,
        1,
        'Louise',
        'Ritchie',
        6.83,
        '4B Allan Park Falkirk',
        '07956263415',
        32,
        'loure',
        'pass'
    ),
    (
        1,
        3,
        'Gregor',
        'Lewis',
        11.24,
        '35 Manse Place Cowdenbeath',
        '07852354179',
        40,
        'grels',
        'pass'
    ),
    (
        1,
        1,
        'Robyn',
        'Curran',
        6.83,
        '52 Fernbank Grangemouth',
        '07343116626',
        12,
        'robcn',
        'pass'
    );
INSERT INTO PriceAdjustment(sku_code, newPrice, date)
VALUES (
        110001,
        25.99,
        '2020/11/15 11:14:03'
    ),
    (
        110001,
        24.99,
        '2021/08/27 09:41:15'
    ),
    (
        110001,
        23.99,
        '2022/06/30 17:51:32'
    ),
    (
        110002,
        25.99,
        '2020/11/15 11:16:13'
    ),
    (
        110003,
        30.99,
        '2020/11/15 11:20:52'
    ),
    (
        110004,
        19.99,
        '2020/11/15 11:24:31'
    ),
    (
        120001,
        89.99,
        '2020/12/20 14:17:46'
    ),
    (
        120002,
        95.95,
        '2020/12/20 14:21:00'
    ),
    (
        120003,
        580.99,
        '2020/12/20 14:33:58'
    ),
    (
        120003,
        595.99,
        '2021/07/31 17:00:53'
    ),
    (
        120004,
        112.00,
        '2020/12/20 14:36:33'
    ),
    (
        210001,
        89.95,
        '2022/02/15 10:23:15'
    ),
    (
        210002,
        80.99,
        '2022/02/15 10:27:01'
    ),
    (
        210002,
        77.99,
        '2022/05/14 11:01:12'
    ),
    (
        210003,
        121.95,
        '2022/02/15 10:30:47'
    ),
    (
        210004,
        146.99,
        '2022/02/15 10:36:29'
    ),
    (
        220001,
        99.99,
        '2022/03/08 13:44:51'
    ),
    (
        220001,
        91.95,
        '2022/03/08 13:44:50'
    ),
    (
        220001,
        87.99,
        '2022/10/18 12:11:56'
    ),
    (
        220002,
        85.95,
        '2022/03/08 13:50:18'
    ),
    (
        220002,
        79.95,
        '2022/05/22 13:50:18'
    ),
    (
        220003,
        99.99,
        '2022/03/08 13:54:40'
    ),
    (
        220004,
        112.45,
        '2022/03/08 14:00:03'
    ),
    (
        310001,
        359.99,
        '2022/03/16 09:24:35'
    ),
    (
        310002,
        660.95,
        '2022/03/16 09:27:12'
    ),
    (
        310002,
        699.99,
        '2022/05/28 16:41:19'
    ),
    (
        310002,
        688.99,
        '2022/09/12 13:36:34'
    ),
    (
        310003,
        296.99,
        '2022/03/16 09:29:45'
    ),
    (
        310004,
        10000.00,
        '2022/03/16 09:31:51'
    ),
    (
        320001,
        299.99,
        '2022/03/16 09:35:19'
    ),
    (
        320002,
        315.95,
        '2022/03/16 09:38:48'
    ),
    (
        330001,
        210.99,
        '2022/04/05 16:03:16'
    ),
    (
        330002,
        175.95,
        '2022/04/05 16:07:47'
    );