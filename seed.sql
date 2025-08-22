INSERT INTO `archiveData` (`id`, `icda_1_school`, `icda_1_date`, `icda_2_school`, `icda_2_date`, `icda_3_school`, `icda_3_date`, `icda_4_school`, `icda_4_date`, `icda_5_school`, `icda_5_date`, `icda_state_date`, `archive_time`) VALUES
(1, 'Rolling Meadows High School', '2019-09-28', 'Grayslake Central High School', '2019-10-26', 'Lyons Township High School', '2019-11-16', 'Dundee-Crown High School', '2019-12-07', 'Wheeling High School', '2020-01-25', '2020-02-22', '2025-07-24 22:15:23'),
(2, 'Zoom', '2020-09-26', 'Zoom', '2020-10-24', 'Zoom', '2020-11-14', 'Zoom', '2020-12-12', 'Zoom', '2021-01-23', '2021-02-27', '2025-07-24 22:16:39'),
(3, 'Rolling Meadows High School', '2021-09-25', 'Adlai E. Stevenson High School', '2021-10-30', 'Elk Grove High School', '2021-11-13', 'Grayslake North High School', '2021-12-18', 'Hoffman Estates High School', '2022-01-29', '2022-02-26', '2025-07-24 22:17:48'),
(4, 'Grayslake Central High School', '2022-09-24', 'Adlai E. Stevenson High School', '2022-10-29', 'James B. Conant High School', '2022-11-12', 'Hampshire High School', '2022-12-06', 'Highland Park High School', '2023-01-22', '2023-02-25', '2025-07-24 22:19:24'),
(5, 'Elk Grove High School', '2023-09-30', 'Adlai E. Stevenson High School', '2023-10-28', 'Wheeling High School', '2023-11-11', 'Hoffman Estates High School', '2023-12-09', 'Highland Park High School', '2024-01-20', '2024-02-24', '2024-07-24 22:21:07'),
(6, 'Addison Trail High School', '2024-09-21', 'Adlai E. Stevenson High School', '2024-10-19', 'Barrington High School', '2024-11-09', 'Deerfield High School', '2024-12-07', 'Dundee-Crown High School', '2025-01-18', '2025-02-22', '2025-07-29 21:32:15');

INSERT INTO `contacts` (`id`, `tournament`, `name`, `email`) VALUES
(13, 1, 'Carl Schwartz', 'cschwartz@d211.org'),
(14, 1, 'John Smith', 'johnsmith@example.com');

INSERT INTO `oversight` (`id`, `name`, `email`, `image_url`) VALUES
(1, 'Tim Waters', 'tim.waters@d214.org', '/public/uploads/687ac3acd6eae3.15489988.jpeg'),
(2, 'Michelle Pitts', 'mpitts@naperville203.org', '/public/uploads/687ac3eebe1e29.09770657.jpeg'),
(3, 'Chris D&#039;Amico', 'cdamico@d127.org', '/public/uploads/687ac412856435.11347293.jpeg'),
(4, 'Randy Smith', 'rsmith@naperville203.org', '/public/uploads/687db71f046892.78498653.jpeg'),
(5, 'Carl Schwartz', 'cschwartz@d211.org', '/public/uploads/687ac424814329.16695716.jpeg'),
(6, 'Dustin Zubert', 'dzubert@d127.org', '/public/uploads/687ac42ae62254.51654072.jpeg'),
(7, 'Tom Swiontek', 'tswiontek@lths.net', '/public/uploads/687ac431066ba8.39664944.jpeg');

INSERT INTO `posts` (`id`, `slug`, `title`, `image_url`, `creation_date`, `edit_date`, `markdown`) VALUES
(1, 'new-website', 'New Website', '/public/uploads/687fb38e8d9014.37188551.webp', '2025-07-08 21:06:15', '2025-08-21 23:12:47', '## New Features\r\n\r\n\r\nThe **final** update of the new ICDA Website has just been released! Version 2.0 contains support for a ton of new features:\r\n\r\n* **Backend updates**: Server-side code to keep tournament results, legislation, and other critical information always up-to-date.\r\n* **News**: Posts by the ICDA Oversight Committee detailing all of the new things ICDA is doing.\r\n* **Archive**: Records of old tournament information updated annually.\r\n* **SEO and Social Media Optimizations**: Additional site metadata to help spread the word about ICDA on Google, Bing, Facebook, Instagram, and other digital platforms.\r\n* ...and so much more!\r\n\r\nSpend some time checking out all of the new features! Thanks for using this website.\r\n\r\nIf you encounter any bugs and/or other issues with this site, please reach out using the link at the very bottom of the page so we can get your issue addressed.\r\n\r\n***\r\n\r\n## A Note From the Creator\r\n\r\n\r\nDeveloping this website has been the opportunity of a lifetime - working on this two-year project has allowed me to hone my computer skills, learn about my field, and connect with one of my favorite activities in a way previously thought unimaginable. While I will no longer be updating the ICDA Website (save for any future bug fixes), this website will not be lost to me as one of the best parts of not just my time in congressional debate, but in all of my high school career. \r\n\r\nThank you so much to the following people for assisting the development of this website:\r\n\r\n* The ICDA Oversight Committee (especially former President Tim Waters and Technology Commissioner Carl Schwartz) for providing this opportunity and for connecting me with the resources necessary to get the job done.\r\n* The 2024-2025 ICDA Captains Committee for always giving helpful feedback and amazing suggestions for how to improve the website even more.\r\n* Former ICDA debater Sunny Gandhi for creating the old ICDA Website and for inspiring/informing the development of the current website.\r\n* My friend Harshil Joshi for guiding me step-by-step through the website design process, for informing the design of the website so much, and for stepping in to write almost all of the animations seen on each page (among many other things).\r\n\r\n\r\nFor all the debaters (old and new) reading this message, keep sticking with this amazing activity. Not only is congressional debate a great place to learn and grow as a speaker, researcher, and debater, but it opens up doors and creates amazing experiences in the wildest places. From winning speaking awards to making friends in chamber to even coding websites, there is something in congressional debate for everybody to enjoy and grow from. I hope this website can be a tool that helps you achieve some of those amazing things.\r\n\r\n*\\- Scott Gilbert\\, Former ICDA Debater & Conant High School \'25*');

INSERT INTO `rules` (`id`, `name`, `number`, `summary`) VALUES
(34, 'Junior varsity transitioning', 9, 'Debaters new to the current season can be moved between JV and Varsity can be moved back and forth at the discretion of their coach. However, debaters who competed in a previous season (even if only for one tournament) may only compete in varsity chambers.'),
(35, 'Vote capping', 24, 'For any election (election of Presiding Officer, Best Presiding Officer, Second Place and Third Place Speakers, Best Legislation) each school is capped at a maximum of two votes, and representatives from that school must collectively decide each of the two votes.'),
(36, 'Maximum legislation time', 26, 'Once procedural issues at the beginning of the session are completed, the Presiding Officer will calculate the remaining time for debate in the session. The maximum amount of time the chamber may spend on any legislation will be one half of that remaining time, rounded up to the nearest minute.'),
(37, 'Cumulative precedence', 28, 'When choosing speakers, the Presiding Officer must choose the debater who has given the least amount of speeches throughout the ENTIRE tournament. In the event of a tie, they may choose one of those debaters by their own discretion, which they should have indicated at the beginning of the session. However, speaking order from previous sessions may NOT carry over.'),
(38, 'Speech order', 29, 'Debate will begin with a four-minute authorship speech, or a three-minute sponsorship if the author is not present in the chamber. Following that speech, a debater will deliver a speech in opposition of the bill. This speech will be four minutes long (also known as a conship) if it follows a four-minute authorship. It will be three minutes long if it follows a three-minute sponsorship speech. This alternating process of three minute speeches will continue until the time limit expires.'),
(39, 'Gaveling procedure', 30, 'During a speech, the Presiding Officer will tap the gavel once after two minutes have passed, twice after two minutes and thirty seconds have passed, and three times after three minutes have passed. After giving the speaker a five second grace period, they will gavel the speaker down.'),
(40, 'Questioning timing', 31, 'During questioning, each questioner will have a 1-minute block of time that cannot be yielded to the next questioner. After a 4-minute authorship or conship speech, there will be three such blocks of questioning. After any other speech, there will be two such blocks of questioning.'),
(41, 'Questioning precedence', 32, 'Debaters who have not questioned a speaker have precedence over those who have and the Presiding Officer must acknowledge these people before s/he recognizes others.'),
(42, 'Speech scoring', 35, 'Each judge will evaluate each speech on a scale of 0-6 based on quality of debate, organization, delivery, and question responses. Furthermore, they will also provide debaters with feedback and critiques and share their critiques with the other judge. While judges may evaluate their own participant’s speeches, these scores will not be averaged into speech totals.'),
(43, 'Nominations', 37, 'At the end of each session, each judge will independently nominate two debaters (not from their own school) they feel should be considered for speaker awards, which they will rank first and second.'),
(44, 'Presiding Officer scoring', 39, 'If speakers have spoken a maximum of once, the two judges’ scores shall be averaged to result in one Presiding Officer score out of 6 points. If the maximum number of speeches is two or greater, both judges’ scores will comprise the P.O.’s score out of 12 points. The P.O’s score may exceed the highest speaker’s score.'),
(45, 'Second and third place speakers', 47, 'At the end of the tournament, debaters will vote in a judge-run election between each of the nominees to determine the second and third place speakers. The second place speaker will be the first debater to receive a simple majority of the votes cast, and the third place speaker will be the nominee on that ballot who receives the second-highest number of votes. In the event no nominee receives a simple majority, the judges will remove the nominee(s) who received the least number of votes and will hold another round of voting. This procedure will continue until a nominee receives a simple majority. Ties for either place are broken by the Oversight Committee (see rule 48).'),
(46, 'First place speaker', 49, 'The debater who has the highest speech score average, and has given at least three speeches over the course of the tournament, will receive the first place award. In the event of a tie, the Oversight Committee will break it based on number of nominations received and, if a tie is still present, by the ranking of those nominations.'),
(47, 'Large school sweepstakes', 52, 'Each debater\'s points (including ethos, speeches, and presiding officer points) will be totaled up. The top eight such point-receivers from each large school will be totaled, and the schools with the first, second, and third-highest numbers of points will receive awards. In the event of a tie, duplicate awards will be given.'),
(48, 'Small school sweepstakes', 56, 'Each debater\'s points (including ethos, speeches, and presiding officer points) will be totaled up. However, only the top four such point-receivers from each small school will be totaled, and the schools with the first, second, and third-highest numbers of points will receive awards. In the event of a tie, duplicate awards will be given.'),
(49, 'Electronic devices', 67, 'Debaters may use electronic devices and access the internet while in the chamber. However, they may not use any electronic devices while they are either speaking or questioning.');

INSERT INTO `schools` (`id`, `name`, `image_url`) VALUES
(1, 'Addison Trail High School', '/public/uploads/687ac6d06a8611.97799935.png'),
(2, 'Adlai E. Stevenson High School', '/public/uploads/687da4723387b6.09014544.png'),
(3, 'Barrington High School', '/public/uploads/687da478b96032.74322348.png'),
(4, 'Deerfield High School', '/public/uploads/687da4804883d5.47075981.png'),
(5, 'Dundee-Crown High School', '/public/uploads/687da48d8ce901.10321750.png'),
(6, 'Elk Grove High School', '/public/uploads/687da4becc3d75.87370543.png'),
(7, 'Glenbrook South High School', '/public/uploads/687da4ca903162.98388718.png'),
(8, 'Grant Community High School', '/public/uploads/687da4ee579b75.76681260.png'),
(9, 'Grayslake Central High School', '/public/uploads/687da4f60daf98.55675503.png'),
(10, 'Grayslake North High School', '/public/uploads/687da4fb89b405.27181622.png'),
(11, 'Hampshire High School', '/public/uploads/687da502306aa6.41211945.png'),
(12, 'Harry D. Jacobs High School', '/public/uploads/687da5253503c5.67064423.png'),
(13, 'Highland Park High School', '/public/uploads/687da52b4ff679.76356295.png'),
(14, 'Hoffman Estates High School', '/public/uploads/687da5329802e2.95192052.png'),
(15, 'Illinois Mathematics and Science Academy', '/public/uploads/687da538b4c5e6.76360032.png'),
(16, 'James B. Conant High School', '/public/uploads/687da53e689a26.14161217.png'),
(17, 'John Hersey High School', '/public/uploads/687da545289ef9.62470553.png'),
(18, 'Lake Forest High School', '/public/uploads/687daed5dacf42.38570595.png'),
(19, 'Lyons Township High School', '/public/uploads/687daedb330080.72180734.png'),
(20, 'Naperville Central High School', '/public/uploads/687daee09ea934.51805911.png'),
(21, 'Naperville North High School', '/public/uploads/687daee61527a4.40315549.png'),
(22, 'New Trier High School', '/public/uploads/687daeec54d150.29552173.png'),
(23, 'Notre Dame College Prep', '/public/uploads/687daf241d60a6.92034153.png'),
(24, 'Prospect High School', '/public/uploads/687daf2f12c747.26500243.png'),
(25, 'Rolling Meadows High School', '/public/uploads/687daf393e5f03.28963293.png'),
(26, 'Schaumburg High School', '/public/uploads/687daf928fc544.48459358.png'),
(27, 'Wauconda High School', '/public/uploads/687daf97d8e0e4.61021715.png'),
(28, 'Wheeling High School', '/public/uploads/687daf440d1d54.65417142.png'),
(29, 'William Fremd High School', '/public/uploads/687daf4a7413b4.22058680.png'),
(30, 'Woodlands Academy of the Sacred Heart', '/public/uploads/687daf517f6cd2.52442977.png');

INSERT INTO `tournaments` (`id`, `date`, `school_id`, `tabroom`) VALUES
(1, '2024-09-21', 10, 'https://www.tabroom.com/index/tourn/index.mhtml?tourn_id=32358'),
(2, '2024-10-19', 28, 'https://www.tabroom.com/index/tourn/index.mhtml?tourn_id=32956'),
(3, '2024-11-09', 16, 'https://www.tabroom.com/index/tourn/index.mhtml?tourn_id=33030'),
(4, '2024-12-07', 19, 'https://www.tabroom.com/index/tourn/index.mhtml?tourn_id=33472'),
(5, '2025-01-18', 13, 'https://www.tabroom.com/index/tourn/index.mhtml?tourn_id=33473'),
(6, '2025-02-22', 1, 'https://www.tabroom.com/index/tourn/index.mhtml?tourn_id=33474');