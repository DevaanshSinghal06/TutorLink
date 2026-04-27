-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 27, 2026
-- Server version: 8.0.44
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

 /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TutorLink`
--

-- --------------------------------------------------------
-- Table structure for table `Schools`
-- --------------------------------------------------------

CREATE TABLE `Schools` (
  `SchoolAbbrev` varchar(4) NOT NULL,
  `SchoolFull` varchar(100) NOT NULL,
  PRIMARY KEY (`SchoolAbbrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Schools`
--

INSERT INTO `Schools` (`SchoolAbbrev`, `SchoolFull`) VALUES
('BAHT', 'Harry W. Bass Jr. School of Arts, Humanities, and Technology'),
('BBS', 'School of Behavioral and Brain Sciences'),
('ECS', 'Erik Jonsson School of Engineering and Computer Science'),
('EPPS', 'School of Economic, Political and Policy Sciences'),
('HWHC', 'Hobson Wildenthal Honors College'),
('IS', 'School of Interdisciplinary Studies'),
('JSOM', 'Naveen Jindal School of Management'),
('NSM', 'School of Natural Sciences and Mathematics');

-- --------------------------------------------------------
-- Table structure for table `Courses`
-- --------------------------------------------------------

CREATE TABLE `Courses` (
  `CourseIndex` int NOT NULL AUTO_INCREMENT,
  `CoursePrefix` varchar(5) NOT NULL,
  `CourseNumber` varchar(10) DEFAULT NULL,
  `CourseName` varchar(255) NOT NULL,
  `SchoolAbbrev` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`CourseIndex`),
  UNIQUE KEY `CoursePrefix` (`CoursePrefix`,`CourseNumber`),
  KEY `fk_courses_school` (`SchoolAbbrev`),
  CONSTRAINT `fk_courses_school`
    FOREIGN KEY (`SchoolAbbrev`) REFERENCES `Schools` (`SchoolAbbrev`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=1573;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`CourseIndex`, `CoursePrefix`, `CourseNumber`, `CourseName`, `SchoolAbbrev`) VALUES
(1110, 'BIS', '1100', 'Interdisciplinary Studies First Year Experience', 'IS'),
(1111, 'BIS', '2190', 'Library Research Skills', 'IS'),
(1112, 'BIS', '2V90', 'Topics in Interdisciplinary Studies', 'IS'),
(1113, 'BIS', '3320', 'The Nature of Intellectual Inquiry', 'IS'),
(1114, 'BIS', '3V03', 'Educational Issues', 'IS'),
(1115, 'BIS', '4303', 'Senior Honors in Interdisciplinary Studies', 'IS'),
(1116, 'BIS', '4306', 'Strategies for Diversity in Education', 'IS'),
(1117, 'BIS', '4310', 'Co-op Education', 'IS'),
(1118, 'BIS', '4V01', 'Special Topics', 'IS'),
(1119, 'BIS', '4V02', 'Independent Study', 'IS'),
(1120, 'BIS', '4V04', 'Internship', 'IS'),
(1121, 'BUAN', '3301', 'AI in Business', 'JSOM'),
(1122, 'BUAN', '4090', 'Business Analytics Internship', 'JSOM'),
(1123, 'BUAN', '4320', 'Database Fundamentals for Analytics', 'JSOM'),
(1124, 'BUAN', '4337', 'Marketing Analytics', 'JSOM'),
(1125, 'BUAN', '4350', 'Spreadsheet Modeling and Analytics', 'JSOM'),
(1126, 'BUAN', '4351', 'Foundations of Business Intelligence', 'JSOM'),
(1127, 'BUAN', '4352', 'Introduction to Web Analytics', 'JSOM'),
(1128, 'BUAN', '4353', 'Business Analytics', 'JSOM'),
(1129, 'BUAN', '4354', 'Advanced Big Data Analytics', 'JSOM'),
(1130, 'BUAN', '4355', 'Data Visualization', 'JSOM'),
(1131, 'BUAN', '4357', 'Supply Chain Analytics, AI, and Advanced Solutions', 'JSOM'),
(1132, 'BUAN', '4373', 'Data Science for Business Applications', 'JSOM'),
(1133, 'BUAN', '4381', 'Object Oriented Programming with Python', 'JSOM'),
(1134, 'BUAN', '4382', 'Applied Artificial Intelligence/Machine Learning', 'JSOM'),
(1135, 'BUAN', '4383', 'Advanced Applied Artificial Intelligence/Machine Learning', 'JSOM'),
(1136, 'BUAN', '4395', 'Capstone Senior Project - Business Analytics', 'JSOM'),
(1137, 'BUAN', '4V81', 'Individual Study in Business Analytics and AI', 'JSOM'),
(1138, 'CGS', '2301', 'Cognitive Science', 'BBS'),
(1139, 'CGS', '3325', 'History of Psychology', 'BBS'),
(1140, 'CGS', '3340', 'Experimental Projects in Cognitive Science', 'BBS'),
(1141, 'CGS', '3342', 'Cognitive and Neural Modeling Laboratory', 'BBS'),
(1142, 'CGS', '3346', 'PYTHON for Biobehavioral Data Analysis', 'BBS'),
(1143, 'CGS', '3361', 'Cognitive Psychology', 'BBS'),
(1144, 'CGS', '4098', 'Directed Research', 'BBS'),
(1145, 'CGS', '4193', 'Internship Preparation', 'BBS'),
(1146, 'CGS', '4314', 'Intelligent Systems Analysis', 'BBS'),
(1147, 'CGS', '4315', 'Intelligent Systems Design', 'BBS'),
(1148, 'CGS', '4320', 'Psychology of Reasoning', 'BBS'),
(1149, 'CGS', '4321', 'Quantitative UX Research', 'BBS'),
(1150, 'CGS', '4352', 'Introduction to Human-Computer Interaction', 'BBS'),
(1151, 'CGS', '4353', 'Qualitative UX Research', 'BBS'),
(1152, 'CGS', '4359', 'Cognitive Neuroscience', 'BBS'),
(1153, 'CGS', '4362', 'Perception', 'BBS'),
(1154, 'CGS', '4385', 'Neuropsychology', 'BBS'),
(1155, 'CGS', '4386', 'Adult Development and Aging', 'BBS'),
(1156, 'CGS', '4389', 'Developmental Cognitive Neuroscience', 'BBS'),
(1157, 'CGS', '4390', 'Directed Research and Writing', 'BBS'),
(1158, 'CGS', '4391', 'Writing and Independent Study', 'BBS'),
(1159, 'CGS', '4394', 'Internship in Cognitive Science', 'BBS'),
(1160, 'CGS', '4395', 'Co-op Fieldwork', 'BBS'),
(1161, 'CGS', '4397', 'Thesis Research', 'BBS'),
(1162, 'CGS', '4V75', 'Honors Seminar', 'BBS'),
(1163, 'CGS', '4V90', 'Special Topics in Cognitive Science', 'BBS'),
(1164, 'CGS', '4V96', 'Teaching Internship', 'BBS'),
(1165, 'CGS', '4V98', 'Directed Research', 'BBS'),
(1166, 'CGS', '4V99', 'Individual Study', 'BBS'),
(1167, 'COMM', '1311', 'Introduction to Communication Studies', 'BAHT'),
(1168, 'COMM', '1315', 'Public Speaking', 'BAHT'),
(1169, 'COMM', '1320', 'Interpersonal Communication', 'BAHT'),
(1170, 'COMM', '2310', 'Introduction to Professional Communication', 'BAHT'),
(1171, 'COMM', '2314', 'Oral Interpretation', 'BAHT'),
(1172, 'COMM', '2317', 'Topics in Communication', 'BAHT'),
(1173, 'COMM', '2320', 'Scientific Communication', 'BAHT'),
(1174, 'COMM', '2335', 'Communication and Popular Culture', 'BAHT'),
(1175, 'COMM', '2351', 'History and Theory of Communication', 'BAHT'),
(1176, 'COMM', '2V71', 'Independent Study in Communications', 'BAHT'),
(1177, 'COMM', '3302', 'Graphics and Images in Professional Communication', 'BAHT'),
(1178, 'COMM', '3303', 'Professional Communication in the Career Fields', 'BAHT'),
(1179, 'COMM', '3310', 'Research Methods in Communication Studies', 'BAHT'),
(1180, 'COMM', '3320', 'Readers Theater', 'BAHT'),
(1181, 'COMM', '3321', 'Professional and Technical Presentations', 'BAHT'),
(1182, 'COMM', '3322', 'Relational Communication', 'BAHT'),
(1183, 'COMM', '3325', 'Advanced Oral Interpretation', 'BAHT'),
(1184, 'COMM', '3330', 'Public Address and the American Presidency', 'BAHT'),
(1185, 'COMM', '3340', 'Team Dynamics', 'BAHT'),
(1186, 'COMM', '3342', 'Advanced Topics in Communication', 'BAHT'),
(1187, 'COMM', '3350', 'Intercultural Communication', 'BAHT'),
(1188, 'COMM', '3352', 'Media and Culture', 'BAHT'),
(1189, 'COMM', '3353', 'Nonverbal Communication', 'BAHT'),
(1190, 'COMM', '3360', 'TV and Radio Announcing', 'BAHT'),
(1191, 'COMM', '4303', 'Advanced Editing', 'BAHT'),
(1192, 'COMM', '4305', 'Communication and Media Law', 'BAHT'),
(1193, 'COMM', '4314', 'Persuasion and Interpersonal Influence', 'BAHT'),
(1194, 'COMM', '4320', 'Communicating for the World Wide Web', 'BAHT'),
(1195, 'COMM', '4330', 'Digital Media and the 21st Century', 'BAHT'),
(1196, 'COMM', '4341', 'Information Design and Usability', 'BAHT'),
(1197, 'COMM', '4352', 'Digital Advocacy: Strategies for Influence', 'BAHT'),
(1198, 'COMM', '4353', 'Political Discourse in a Digital Era', 'BAHT'),
(1199, 'COMM', '4355', 'Organizational Communication', 'BAHT'),
(1200, 'COMM', '4360', 'Communication Ethics', 'BAHT'),
(1201, 'COMM', '4362', 'Communicating in the World of AI', 'BAHT'),
(1202, 'COMM', '4365', 'Storytelling in Professional Contexts', 'BAHT'),
(1203, 'COMM', '4370', 'Communication and Leadership', 'BAHT'),
(1204, 'COMM', '4371', 'Communication and Professionalism', 'BAHT'),
(1205, 'COMM', '4375', 'Professional Communication in Medicine', 'BAHT'),
(1206, 'COMM', '4380', 'Communication in Japan', 'BAHT'),
(1207, 'COMM', '4395', 'Communication in International Contexts', 'BAHT'),
(1208, 'COMM', '4398', 'Capstone', 'BAHT'),
(1209, 'COMM', '4399', 'Communication Internship', 'BAHT'),
(1210, 'COMM', '4V71', 'Advanced Independent Study in Communication', 'BAHT'),
(1211, 'CRWT', '2301', 'Introduction to Creative Writing', 'BAHT'),
(1212, 'CRWT', '3306', 'Fiction Workshop', 'BAHT'),
(1213, 'CRWT', '3308', 'Creative Nonfiction Workshop', 'BAHT'),
(1214, 'CRWT', '3330', 'Translation Workshop', 'BAHT'),
(1215, 'CRWT', '3346', 'Young Adult Fiction Workshop', 'BAHT'),
(1216, 'CRWT', '3351', 'Poetry Workshop', 'BAHT'),
(1217, 'CRWT', '3354', 'Screenwriting Workshop', 'BAHT'),
(1218, 'CRWT', '3355', 'Comics Workshop', 'BAHT'),
(1219, 'CRWT', '4307', 'Advanced Fiction Workshop', 'BAHT'),
(1220, 'CRWT', '4309', 'Advanced Creative Nonfiction Workshop', 'BAHT'),
(1221, 'CRWT', '4353', 'Advanced Poetry Workshop', 'BAHT'),
(1222, 'CRWT', '4355', 'Advanced Screenwriting Workshop', 'BAHT'),
(1223, 'CRWT', '4370', 'Advanced Topics in Creative Writing', 'BAHT'),
(1224, 'CRWT', '4V71', 'Independent Study in Creative Writing', 'BAHT'),
(1225, 'CS', '1134', 'Computer Science Laboratory', 'ECS'),
(1226, 'CS', '1200', 'Introduction to Computer Science and Software Engineering', 'ECS'),
(1227, 'CS', '1324', 'Introduction to Programming for Biomedical Engineers', 'ECS'),
(1228, 'CS', '1325', 'Introduction to Programming', 'ECS'),
(1229, 'CS', '1334', 'Programming Fundamentals for Non-Majors', 'ECS'),
(1230, 'CS', '1335', 'Computer Science I for Non-majors', 'ECS'),
(1231, 'CS', '1337', 'Computer Science I', 'ECS'),
(1232, 'CS', '1436', 'Programming Fundamentals', 'ECS'),
(1233, 'CS', '2305', 'Discrete Mathematics for Computing I', 'ECS'),
(1234, 'CS', '2335', 'Computer Science II for Non-majors', 'ECS'),
(1235, 'CS', '2336', 'Computer Science II', 'ECS'),
(1236, 'CS', '2337', 'Computer Science II', 'ECS'),
(1237, 'CS', '2340', 'Computer Architecture', 'ECS'),
(1238, 'CS', '2V95', 'Undergraduate Topics in Computer Science', 'ECS'),
(1239, 'CS', '2V96', 'Independent Study in Computer Science', 'ECS'),
(1240, 'CS', '3149', 'Competitive Learning in Computer Science', 'ECS'),
(1241, 'CS', '3162', 'Professional Responsibility in Computer Science and Software Engineering', 'ECS'),
(1242, 'CS', '3305', 'Discrete Mathematics for Computing II', 'ECS'),
(1243, 'CS', '3333', 'Data Structures', 'ECS'),
(1244, 'CS', '3341', 'Probability and Statistics in Computer Science and Software Engineering', 'ECS'),
(1245, 'CS', '3345', 'Data Structures and Foundations of Algorithmic Analysis', 'ECS'),
(1246, 'CS', '3349', 'Competitive Learning in Computer Science', 'ECS'),
(1247, 'CS', '3354', 'Software Engineering', 'ECS'),
(1248, 'CS', '3360', 'Computer Graphics for Artists and Designers', 'ECS'),
(1249, 'CS', '3377', 'Systems Programming in UNIX and Other Environments', 'ECS'),
(1250, 'CS', '3385', 'Ethics, Law, Society, and Computing', 'ECS'),
(1251, 'CS', '3V95', 'Undergraduate Topics in Computer Science', 'ECS'),
(1252, 'CS', '3V96', 'Independent Study in Computer Science', 'ECS'),
(1253, 'CS', '4141', 'Digital Systems Laboratory', 'ECS'),
(1254, 'CS', '4301', 'Special Topics in Computer Science', 'ECS'),
(1255, 'CS', '4302', 'Mathematics of Computing', 'ECS'),
(1256, 'CS', '4314', 'Intelligent Systems Analysis', 'ECS'),
(1257, 'CS', '4315', 'Intelligent Systems Design', 'ECS'),
(1258, 'CS', '4332', 'Introduction to Programming Video Games', 'ECS'),
(1259, 'CS', '4334', 'Numerical Analysis', 'ECS'),
(1260, 'CS', '4336', 'Advanced Java', 'ECS'),
(1261, 'CS', '4337', 'Programming Language Paradigms', 'ECS'),
(1262, 'CS', '4339', 'Web Programming Languages', 'ECS'),
(1263, 'CS', '4341', 'Digital Logic and Computer Design', 'ECS'),
(1264, 'CS', '4347', 'Database Systems', 'ECS'),
(1265, 'CS', '4348', 'Operating Systems Concepts', 'ECS'),
(1266, 'CS', '4349', 'Advanced Algorithm Design and Analysis', 'ECS'),
(1267, 'CS', '4352', 'Introduction to Human-Computer Interaction', 'ECS'),
(1268, 'CS', '4361', 'Computer Graphics', 'ECS'),
(1269, 'CS', '4365', 'Artificial Intelligence', 'ECS'),
(1270, 'CS', '4371', 'Introduction to Big Data Management and Analytics', 'ECS'),
(1271, 'CS', '4372', 'Computational Methods for Data Scientists', 'ECS'),
(1272, 'CS', '4375', 'Introduction to Machine Learning', 'ECS'),
(1273, 'CS', '4376', 'Object-Oriented Design', 'ECS'),
(1274, 'CS', '4384', 'Automata Theory', 'ECS'),
(1275, 'CS', '4386', 'Compiler Design', 'ECS'),
(1276, 'CS', '4389', 'Data and Applications Security', 'ECS'),
(1277, 'CS', '4390', 'Computer Networks', 'ECS'),
(1278, 'CS', '4391', 'Introduction to Computer Vision', 'ECS'),
(1279, 'CS', '4392', 'Computer Animation', 'ECS'),
(1280, 'CS', '4393', 'Computer and Network Security', 'ECS'),
(1281, 'CS', '4394', 'Implementation of Modern Operating Systems', 'ECS'),
(1282, 'CS', '4395', 'Human Language Technologies', 'ECS'),
(1283, 'CS', '4396', 'Networking Laboratory', 'ECS'),
(1284, 'CS', '4397', 'Embedded Computer Systems', 'ECS'),
(1285, 'CS', '4398', 'Digital Forensics', 'ECS'),
(1286, 'CS', '4399', 'Senior Honors in Computer Science', 'ECS'),
(1287, 'CS', '4459', 'Cyber Attack and Defense Laboratory', 'ECS'),
(1288, 'CS', '4475', 'Capstone Project', 'ECS'),
(1289, 'CS', '4485', 'Computer Science Project', 'ECS'),
(1290, 'CS', '4V95', 'Undergraduate Topics in Computer Science', 'ECS'),
(1291, 'CS', '4V96', 'Independent Study in Computer Science', 'ECS'),
(1292, 'CS', '4V98', 'Undergraduate Research in Computer Science', 'ECS'),
(1293, 'ECON', '2001', 'Principles of Macroeconomics: Recitation', 'EPPS'),
(1294, 'ECON', '2300', 'Principles of Economics', 'EPPS'),
(1295, 'ECON', '2301', 'Principles of Macroeconomics', 'EPPS'),
(1296, 'ECON', '2302', 'Principles of Microeconomics', 'EPPS'),
(1297, 'ECON', '3310', 'Intermediate Microeconomic Theory', 'EPPS'),
(1298, 'ECON', '3311', 'Intermediate Macroeconomic Theory', 'EPPS'),
(1299, 'ECON', '3312', 'Money and Banking', 'EPPS'),
(1300, 'ECON', '3315', 'Sports Economics', 'EPPS'),
(1301, 'ECON', '3330', 'Economics of Health', 'EPPS'),
(1302, 'ECON', '3332', 'Economic Geography', 'EPPS'),
(1303, 'ECON', '3336', 'Economics of Education', 'EPPS'),
(1304, 'ECON', '3337', 'Economics of Poverty and Inequality', 'EPPS'),
(1305, 'ECON', '3338', 'Economics of Crime', 'EPPS'),
(1306, 'ECON', '3369', 'Political Economy of Terrorism', 'EPPS'),
(1307, 'ECON', '3381', 'Economic History', 'EPPS'),
(1308, 'ECON', '3396', 'Special Topics in Economics', 'EPPS'),
(1309, 'ECON', '4301', 'Game Theory', 'EPPS'),
(1310, 'ECON', '4302', 'Urban and Regional Economics', 'EPPS'),
(1311, 'ECON', '4310', 'Managerial Economics', 'EPPS'),
(1312, 'ECON', '4320', 'Public Sector Economics', 'EPPS'),
(1313, 'ECON', '4324', 'Economics of Sustainability', 'EPPS'),
(1314, 'ECON', '4325', 'Digital Economics and the Law', 'EPPS'),
(1315, 'ECON', '4330', 'Law and Economics', 'EPPS'),
(1316, 'ECON', '4332', 'Energy and Natural Resources Economics', 'EPPS'),
(1317, 'ECON', '4333', 'Environmental Economics', 'EPPS'),
(1318, 'ECON', '4334', 'Experimental Economics', 'EPPS'),
(1319, 'ECON', '4336', 'Environmental Economic Theory and Policy', 'EPPS'),
(1320, 'ECON', '4340', 'Labor Economics and Human Resources', 'EPPS'),
(1321, 'ECON', '4342', 'Public Policies Toward Business', 'EPPS'),
(1322, 'ECON', '4345', 'Industrial Organization', 'EPPS'),
(1323, 'ECON', '4346', 'Technology, Economy, and Society', 'EPPS'),
(1324, 'ECON', '4348', 'Business and Technology', 'EPPS'),
(1325, 'ECON', '4351', 'Mathematical Economics', 'EPPS'),
(1326, 'ECON', '4355', 'Econometrics', 'EPPS'),
(1327, 'ECON', '4360', 'International Trade', 'EPPS'),
(1328, 'ECON', '4362', 'Development Economics', 'EPPS'),
(1329, 'ECON', '4381', 'History of Economic Ideas', 'EPPS'),
(1330, 'ECON', '4382', 'International Finance', 'EPPS'),
(1331, 'ECON', '4385', 'Business and Economic Forecasting', 'EPPS'),
(1332, 'ECON', '4386', 'Contemporary Macroeconomic Policy', 'EPPS'),
(1333, 'ECON', '4396', 'Selected Topics in Economics', 'EPPS'),
(1334, 'ECON', '4V97', 'Independent Study in Economics', 'EPPS'),
(1335, 'ECON', '4V98', 'Internship', 'EPPS'),
(1336, 'ECON', '4V99', 'Senior Honors in Economics', 'EPPS'),
(1337, 'FIN', '3300', 'Personal Finance', 'JSOM'),
(1338, 'FIN', '3305', 'Real Estate Principles', 'JSOM'),
(1339, 'FIN', '3320', 'Business Finance', 'JSOM'),
(1340, 'FIN', '3340', 'Regulation of Business and Financial Markets', 'JSOM'),
(1341, 'FIN', '3350', 'Financial Markets and Institutions', 'JSOM'),
(1342, 'FIN', '3358', 'Real Estate Markets and Investments', 'JSOM'),
(1343, 'FIN', '3360', 'Entrepreneurial Finance', 'JSOM'),
(1344, 'FIN', '3365', 'Real Estate Finance and Principles', 'JSOM'),
(1345, 'FIN', '3370', 'Principles of Risk Management and Insurance', 'JSOM'),
(1346, 'FIN', '3375', 'Life and Estate Planning', 'JSOM'),
(1347, 'FIN', '3380', 'International Financial Management', 'JSOM'),
(1348, 'FIN', '3390', 'Introduction to Financial Modeling', 'JSOM'),
(1349, 'FIN', '3395', 'Financial Modeling and Valuation', 'JSOM'),
(1350, 'FIN', '4080', 'Finance Internship', 'JSOM'),
(1351, 'FIN', '4300', 'Investment Management', 'JSOM'),
(1352, 'FIN', '4303', 'Investment Strategies', 'JSOM'),
(1353, 'FIN', '4305', 'Fixed Income Securities Analysis', 'JSOM'),
(1354, 'FIN', '4307', 'Private Equity', 'JSOM'),
(1355, 'FIN', '4310', 'Intermediate Financial Management', 'JSOM'),
(1356, 'FIN', '4315', 'Behavioral Economics and Finance', 'JSOM'),
(1357, 'FIN', '4320', 'Management of Financial Institutions and Technology', 'JSOM'),
(1358, 'FIN', '4321', 'Real Estate Law and Contracts', 'JSOM'),
(1359, 'FIN', '4322', 'Financial Technology', 'JSOM'),
(1360, 'FIN', '4328', 'Real Estate Valuation', 'JSOM'),
(1361, 'FIN', '4330', 'Estate Planning', 'JSOM'),
(1362, 'FIN', '4331', 'Business Liability Risk Management and Insurance', 'JSOM'),
(1363, 'FIN', '4332', 'Commercial Property Risk Management and Insurance', 'JSOM'),
(1364, 'FIN', '4333', 'Enterprise Risk Management', 'JSOM'),
(1365, 'FIN', '4334', 'Insurance Law and Contracts', 'JSOM'),
(1366, 'FIN', '4335', 'Financial Aspects of Retirement, Compensation, and Employee Benefits', 'JSOM'),
(1367, 'FIN', '4336', 'Risk Systems and Theories', 'JSOM'),
(1368, 'FIN', '4337', 'Business Valuation', 'JSOM'),
(1369, 'FIN', '4338', 'Foundations of Risk Analytics and Applications', 'JSOM'),
(1370, 'FIN', '4340', 'Options and Futures Markets', 'JSOM'),
(1371, 'FIN', '4345', 'Financial Information and Analysis', 'JSOM'),
(1372, 'FIN', '4346', 'Applied Machine Learning in Finance, Insurance, and Real Estate', 'JSOM'),
(1373, 'FIN', '4351', 'Operational Risk Management', 'JSOM'),
(1374, 'FIN', '4352', 'Financial Risk Management', 'JSOM'),
(1375, 'FIN', '4353', 'Principles of Information Security', 'JSOM'),
(1376, 'FIN', '4354', 'Cybersecurity Risk Management', 'JSOM'),
(1377, 'FIN', '4380', 'Fund Management I', 'JSOM'),
(1378, 'FIN', '4381', 'Fund Management II', 'JSOM'),
(1379, 'FIN', '4390', 'Seminar Series in Finance', 'JSOM'),
(1380, 'FIN', '4395', 'Capstone Senior Project - Finance', 'JSOM'),
(1381, 'FIN', '4399', 'Senior Honors in Finance', 'JSOM'),
(1382, 'FIN', '4V80', 'Finance Internship', 'JSOM'),
(1383, 'FIN', '4V90', 'Individual Study in Finance', 'JSOM'),
(1384, 'FIN', '4V99', 'Special Topics in Finance', 'JSOM'),
(1385, 'HONS', '3101', 'Medicine, Politics, and Philosophy', 'HWHC'),
(1386, 'HONS', '3102', 'William Faulkner''s Short Stories', 'HWHC'),
(1387, 'HONS', '3103', 'Honey Bees and Society', 'HWHC'),
(1388, 'HONS', '3104', 'Foreign Film & Political Culture', 'HWHC'),
(1389, 'HONS', '3105', 'Memory', 'HWHC'),
(1390, 'HONS', '3106', 'Positive Psychology', 'HWHC'),
(1391, 'HONS', '3107', 'Early Chinese Literature', 'HWHC'),
(1392, 'HONS', '3108', 'Internet and Public Policy', 'HWHC'),
(1393, 'HONS', '3109', 'Liberal Arts', 'HWHC'),
(1394, 'HONS', '3110', 'The Addicted Brain', 'HWHC'),
(1395, 'HONS', '3111', 'Science Fiction', 'HWHC'),
(1396, 'HONS', '3112', 'Contemporary Topics in Business', 'HWHC'),
(1397, 'HONS', '3113', 'Lives of the Genus Genius', 'HWHC'),
(1398, 'HONS', '3114', 'Scientific Research Concepts', 'HWHC'),
(1399, 'HONS', '3115', 'Exploring Research at UT Dallas', 'HWHC'),
(1400, 'HONS', '3116', 'Excellence', 'HWHC'),
(1401, 'HONS', '3117', 'Science Plays', 'HWHC'),
(1402, 'HONS', '3118', 'Sherlock Holmes', 'HWHC'),
(1403, 'HONS', '3119', 'Medieval Chinese Literature', 'HWHC'),
(1404, 'HONS', '3120', 'Society Against the State', 'HWHC'),
(1405, 'HONS', '3121', 'Combinatorics', 'HWHC'),
(1406, 'HONS', '3122', 'Love, Death, and Hormones', 'HWHC'),
(1407, 'HONS', '3123', 'Pop-up Exhibition Design', 'HWHC'),
(1408, 'HONS', '3199', 'Collegium V Honors Readings', 'HWHC'),
(1409, 'HONS', '3V00', 'Special Topics', 'HWHC'),
(1410, 'HONS', '4098', 'Undergraduate Research', 'HWHC'),
(1411, 'HONS', '4V96', 'Collegium V Honors Capstone', 'HWHC'),
(1412, 'HONS', '4V97', 'Independent Study in Honors', 'HWHC'),
(1413, 'MATH', '1306', 'College Algebra for the Non-Scientist', 'NSM'),
(1414, 'MATH', '1314', 'College Algebra', 'NSM'),
(1415, 'MATH', '1316', 'Trigonometry', 'NSM'),
(1416, 'MATH', '1325', 'Applied Calculus I', 'NSM'),
(1417, 'MATH', '1326', 'Applied Calculus II', 'NSM'),
(1418, 'MATH', '2306', 'Analytic Geometry', 'NSM'),
(1419, 'MATH', '2312', 'Precalculus', 'NSM'),
(1420, 'MATH', '2333', 'Matrices, Vectors, and Data', 'NSM'),
(1421, 'MATH', '2370', 'Introduction to Programming with MATLAB', 'NSM'),
(1422, 'MATH', '2399', 'Research and Advanced Writing', 'NSM'),
(1423, 'MATH', '2413', 'Differential Calculus', 'NSM'),
(1424, 'MATH', '2414', 'Integral Calculus', 'NSM'),
(1425, 'MATH', '2415', 'Calculus of Several Variables', 'NSM'),
(1426, 'MATH', '2417', 'Calculus I', 'NSM'),
(1427, 'MATH', '2418', 'Linear Algebra', 'NSM'),
(1428, 'MATH', '2419', 'Calculus II', 'NSM'),
(1429, 'MATH', '2420', 'Differential Equations with Applications', 'NSM'),
(1430, 'MATH', '2V90', 'Topics in Mathematics - Level 2', 'NSM'),
(1431, 'MATH', '3301', 'Mathematics for Elementary and Middle School Teachers', 'NSM'),
(1432, 'MATH', '3303', 'Mathematical Modeling', 'NSM'),
(1433, 'MATH', '3305', 'Foundations of Measurement and Informal Geometry', 'NSM'),
(1434, 'MATH', '3307', 'Mathematical Problem Solving for Teachers', 'NSM'),
(1435, 'MATH', '3310', 'Theoretical Concepts of Calculus', 'NSM'),
(1436, 'MATH', '3311', 'Abstract Algebra I', 'NSM'),
(1437, 'MATH', '3312', 'Abstract Algebra II', 'NSM'),
(1438, 'MATH', '3315', 'Discrete Mathematics and Combinatorics', 'NSM'),
(1439, 'MATH', '3321', 'Geometry', 'NSM'),
(1440, 'MATH', '3323', 'Elementary Number Theory', 'NSM'),
(1441, 'MATH', '3335', 'Informatics and Programming', 'NSM'),
(1442, 'MATH', '3336', 'Bioinformatics', 'NSM'),
(1443, 'MATH', '3351', 'Advanced Calculus', 'NSM'),
(1444, 'MATH', '3379', 'Complex Variables', 'NSM'),
(1445, 'MATH', '3380', 'Differential Geometry', 'NSM'),
(1446, 'MATH', '3397', 'Mathematical Problem Solving', 'NSM'),
(1447, 'MATH', '4301', 'Mathematical Analysis I', 'NSM'),
(1448, 'MATH', '4302', 'Mathematical Analysis II', 'NSM'),
(1449, 'MATH', '4332', 'Scientific Computing using Python', 'NSM'),
(1450, 'MATH', '4334', 'Numerical Analysis', 'NSM'),
(1451, 'MATH', '4341', 'Topology', 'NSM'),
(1452, 'MATH', '4355', 'Methods of Applied Mathematics', 'NSM'),
(1453, 'MATH', '4362', 'Partial Differential Equations', 'NSM'),
(1454, 'MATH', '4365', 'Introduction to Deep Learning', 'NSM'),
(1455, 'MATH', '4381', 'Structure of Modern Geometry', 'NSM'),
(1456, 'MATH', '4390', 'Senior Research and Advanced Writing', 'NSM'),
(1457, 'MATH', '4399', 'Senior Honors in Mathematics', 'NSM'),
(1458, 'MATH', '4475', 'Capstone Project', 'NSM'),
(1459, 'MATH', '4V03', 'Independent Study in Mathematics', 'NSM'),
(1460, 'MATH', '4V91', 'Undergraduate Topics in Mathematics', 'NSM'),
(1461, 'PSY', '2301', 'Introduction to Psychology', 'BBS'),
(1462, 'PSY', '2314', 'Lifespan Development', 'BBS'),
(1463, 'PSY', '2317', 'Statistics for Psychology', 'BBS'),
(1464, 'PSY', '2364', 'Animal Communication', 'BBS'),
(1465, 'PSY', '3100', 'Careers in Psychology', 'BBS'),
(1466, 'PSY', '3310', 'Child Development', 'BBS'),
(1467, 'PSY', '3322', 'Psychology of Adjustment', 'BBS'),
(1468, 'PSY', '3324', 'Psychology of Gender', 'BBS'),
(1469, 'PSY', '3326', 'Intergroup Emotion and Social Change', 'BBS'),
(1470, 'PSY', '3331', 'Social Psychology', 'BBS'),
(1471, 'PSY', '3332', 'Social and Personality Development', 'BBS'),
(1472, 'PSY', '3333', 'Clinical Psychology', 'BBS'),
(1473, 'PSY', '3336', 'Infancy', 'BBS'),
(1474, 'PSY', '3338', 'Adolescence', 'BBS'),
(1475, 'PSY', '3339', 'Educational Psychology', 'BBS'),
(1476, 'PSY', '3342', 'Exceptional Children', 'BBS'),
(1477, 'PSY', '3350', 'Psychology of Communication', 'BBS'),
(1478, 'PSY', '3351', 'Mass Communication and Behavior', 'BBS'),
(1479, 'PSY', '3352', 'Biological Psychology', 'BBS'),
(1480, 'PSY', '3355', 'Psychology of Creativity', 'BBS'),
(1481, 'PSY', '3360', 'History of Psychology', 'BBS'),
(1482, 'PSY', '3361', 'Cognitive Psychology', 'BBS'),
(1483, 'PSY', '3362', 'Cognitive Development', 'BBS'),
(1484, 'PSY', '3370', 'Positive Psychology', 'BBS'),
(1485, 'PSY', '3380', 'Writing in Psychology', 'BBS'),
(1486, 'PSY', '3392', 'Research Design and Analysis', 'BBS'),
(1487, 'PSY', '3393', 'Experimental Projects in Psychology', 'BBS'),
(1488, 'PSY', '4098', 'Directed Research', 'BBS'),
(1489, 'PSY', '4099', 'Individual Study', 'BBS'),
(1490, 'PSY', '4193', 'Internship Preparation', 'BBS'),
(1491, 'PSY', '4320', 'Psychology of Reasoning', 'BBS'),
(1492, 'PSY', '4323', 'Cultural Diversity and Psychology', 'BBS'),
(1493, 'PSY', '4324', 'The Psychology of Prejudice', 'BBS'),
(1494, 'PSY', '4325', 'Death and Dying', 'BBS'),
(1495, 'PSY', '4326', 'Clinical Psychological Science', 'BBS'),
(1496, 'PSY', '4328', 'Health Psychology', 'BBS'),
(1497, 'PSY', '4331', 'Personality and Individual Differences', 'BBS'),
(1498, 'PSY', '4343', 'Adult Psychopathology', 'BBS'),
(1499, 'PSY', '4344', 'Child Psychopathology', 'BBS'),
(1500, 'PSY', '4345', 'Violence in the Family', 'BBS'),
(1501, 'PSY', '4346', 'Human Sexuality', 'BBS'),
(1502, 'PSY', '4347', 'Marriage and Family Psychology', 'BBS'),
(1503, 'PSY', '4348', 'Sleep and Mental Health', 'BBS'),
(1504, 'PSY', '4352', 'Emerging Adulthood Development', 'BBS'),
(1505, 'PSY', '4359', 'Cognitive Neuroscience', 'BBS'),
(1506, 'PSY', '4360', 'Pediatric Disorders', 'BBS'),
(1507, 'PSY', '4362', 'Perception', 'BBS'),
(1508, 'PSY', '4365', 'Psychology of Music', 'BBS'),
(1509, 'PSY', '4370', 'Industrial and Organizational Psychology', 'BBS'),
(1510, 'PSY', '4372', 'Forensic Psychology', 'BBS'),
(1511, 'PSY', '4373', 'Psychological Assessment', 'BBS'),
(1512, 'PSY', '4377', 'Conflict Resolution', 'BBS'),
(1513, 'PSY', '4385', 'Neuropsychology', 'BBS'),
(1514, 'PSY', '4386', 'Adult Development and Aging', 'BBS'),
(1515, 'PSY', '4389', 'Developmental Cognitive Neuroscience', 'BBS'),
(1516, 'PSY', '4390', 'Directed Research and Writing', 'BBS'),
(1517, 'PSY', '4391', 'Individual Study and Writing', 'BBS'),
(1518, 'PSY', '4392', 'Teaching and Professional Skills Practicum', 'BBS'),
(1519, 'PSY', '4393', 'Language in Culture and Society', 'BBS'),
(1520, 'PSY', '4394', 'Internship in Psychology', 'BBS'),
(1521, 'PSY', '4395', 'Co-op Fieldwork', 'BBS'),
(1522, 'PSY', '4397', 'Thesis Research', 'BBS'),
(1523, 'PSY', '4V75', 'Honors Seminar', 'BBS'),
(1524, 'PSY', '4V90', 'Special Topics in Psychology', 'BBS'),
(1525, 'PSY', '4V91', 'Green Fellowship Directed Research', 'BBS'),
(1526, 'PSY', '4V96', 'Teaching Internship', 'BBS'),
(1527, 'PSY', '4V98', 'Directed Research', 'BBS'),
(1528, 'PSY', '4V99', 'Individual Study', 'BBS'),
(1529, 'SE', '2340', 'Computer Architecture', 'ECS'),
(1530, 'SE', '2V95', 'Undergraduate Topics in Software Engineering', 'ECS'),
(1531, 'SE', '2V96', 'Independent Study in Software Engineering', 'ECS'),
(1532, 'SE', '3162', 'Professional Responsibility in Computer Science and Software Engineering', 'ECS'),
(1533, 'SE', '3306', 'Mathematical Foundations of Software Engineering', 'ECS'),
(1534, 'SE', '3341', 'Probability and Statistics in Computer Science and Software Engineering', 'ECS'),
(1535, 'SE', '3345', 'Data Structures and Foundations of Algorithmic Analysis', 'ECS'),
(1536, 'SE', '3354', 'Software Engineering', 'ECS'),
(1537, 'SE', '3377', 'Systems Programming in UNIX and Other Environments', 'ECS'),
(1538, 'SE', '3V95', 'Undergraduate Topics in Software Engineering', 'ECS'),
(1539, 'SE', '3V96', 'Independent Study in Software Engineering', 'ECS'),
(1540, 'SE', '4347', 'Database Systems', 'ECS'),
(1541, 'SE', '4348', 'Operating Systems Concepts', 'ECS'),
(1542, 'SE', '4351', 'Requirements Engineering', 'ECS'),
(1543, 'SE', '4352', 'Software Architecture and Design', 'ECS'),
(1544, 'SE', '4367', 'Software Testing, Verification, Validation and Quality Assurance', 'ECS'),
(1545, 'SE', '4376', 'Object-Oriented Design', 'ECS'),
(1546, 'SE', '4381', 'Software Project Planning and Management', 'ECS'),
(1547, 'SE', '4399', 'Senior Honors in Software Engineering', 'ECS'),
(1548, 'SE', '4485', 'Software Engineering Project', 'ECS'),
(1549, 'SE', '4V95', 'Undergraduate Topics in Software Engineering', 'ECS'),
(1550, 'SE', '4V96', 'Independent Study in Software Engineering', 'ECS'),
(1551, 'SE', '4V98', 'Undergraduate Research in Software Engineering', 'ECS'),
(1552, 'STAT', '1342', 'Statistical Decision Making', 'NSM'),
(1553, 'STAT', '2332', 'Introductory Statistics for Life Sciences', 'NSM'),
(1554, 'STAT', '3332', 'Statistics for Life Sciences', 'NSM'),
(1555, 'STAT', '3335', 'Informatics and Programming', 'NSM'),
(1556, 'STAT', '3336', 'Bioinformatics', 'NSM'),
(1557, 'STAT', '3337', 'Elements of Biostatistics and Epidemiology', 'NSM'),
(1558, 'STAT', '3341', 'Probability and Statistics in Computer Science and Software Engineering', 'NSM'),
(1559, 'STAT', '3355', 'Introduction to Data Analysis', 'NSM'),
(1560, 'STAT', '3360', 'Probability and Statistics for Management and Economics', 'NSM'),
(1561, 'STAT', '4338', 'Biostatistics and Machine Learning Lab', 'NSM'),
(1562, 'STAT', '4351', 'Probability', 'NSM'),
(1563, 'STAT', '4352', 'Mathematical Statistics', 'NSM'),
(1564, 'STAT', '4354', 'Numerical and Statistical Computing', 'NSM'),
(1565, 'STAT', '4355', 'Applied Linear Models', 'NSM'),
(1566, 'STAT', '4360', 'Introduction to Statistical Learning', 'NSM'),
(1567, 'STAT', '4365', 'Introduction to Deep Learning', 'NSM'),
(1568, 'STAT', '4382', 'Stochastic Processes', 'NSM'),
(1569, 'STAT', '4475', 'Capstone Project', 'NSM'),
(1570, 'STAT', '4V02', 'Independent Study in Statistics', 'NSM'),
(1571, 'STAT', '4V96', 'Epidemiological Research Lab', 'NSM'),
(1572, 'STAT', '4V97', 'Undergraduate Topics in Statistics', 'NSM');

-- --------------------------------------------------------
-- Table structure for table `Students`
-- --------------------------------------------------------

CREATE TABLE `Students` (
  `StudentIndex` int NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `Surname` varchar(35) DEFAULT NULL,
  `Age` int NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `NetID` varchar(9) DEFAULT NULL,
  `CometID` varchar(10) DEFAULT NULL,
  `GradYear` int DEFAULT NULL,
  PRIMARY KEY (`StudentIndex`),
  UNIQUE KEY `NetID` (`NetID`),
  UNIQUE KEY `CometID` (`CometID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`StudentIndex`, `FirstName`, `Surname`, `Age`, `PhoneNumber`, `Email`, `NetID`, `CometID`, `GradYear`) VALUES
(1002, 'John', 'Wayne', 20, '469-555-5678', 'john@utdallas.edu', 'jxd210001', '2023987654', 2028),
(1003, 'Devaansh', 'Singhal', 19, '2147632036', 'dxs200030@utdallas.edu', 'DXS200030', '2021563607', 2028);

-- --------------------------------------------------------
-- Table structure for table `Tutors`
-- --------------------------------------------------------

CREATE TABLE `Tutors` (
  `TutorIndex` int NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `Surname` varchar(35) DEFAULT NULL,
  `Age` int NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `TutorType` varchar(10) NOT NULL,
  `NetID` varchar(9) DEFAULT NULL,
  `CometID` varchar(10) DEFAULT NULL,
  `TutorID` varchar(20) DEFAULT NULL,
  `Company` varchar(50) DEFAULT NULL,
  `Other` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`TutorIndex`),
  UNIQUE KEY `NetID` (`NetID`),
  UNIQUE KEY `CometID` (`CometID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Tutors`
--

INSERT INTO `Tutors` (`TutorIndex`, `FirstName`, `Surname`, `Age`, `PhoneNumber`, `Email`, `TutorType`, `NetID`, `CometID`, `TutorID`, `Company`, `Other`) VALUES
(1, 'Noah', 'Hoenig', 20, NULL, 'Noah.Hoenig@utdallas.edu', 'UTD', 'NJH230000', '2024420569', NULL, NULL, NULL),
(2, 'Devaansh', 'Singhal', 19, '2147632036', 'dxs200030@utdallas.edu', 'UTD', 'DXS200030', '2021563607', NULL, NULL, NULL);

-- --------------------------------------------------------
-- Table structure for table `Locations`
-- --------------------------------------------------------

CREATE TABLE `Locations` (
  `LocationIndex` int NOT NULL AUTO_INCREMENT,
  `BuildingID` varchar(4) NOT NULL,
  `BuildingName` varchar(100) NOT NULL,
  `RoomNumber` varchar(5) NOT NULL,
  `HoursAvailable` varchar(255) NOT NULL,
  `RoomName` varchar(100) DEFAULT NULL,
  `RoomType` varchar(50) DEFAULT NULL,
  `Capacity` int DEFAULT NULL,
  PRIMARY KEY (`LocationIndex`),
  UNIQUE KEY `BuildingID` (`BuildingID`,`RoomNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=12;

--
-- Dumping data for table `Locations`
--

INSERT INTO `Locations` (`LocationIndex`, `BuildingID`, `BuildingName`, `RoomNumber`, `HoursAvailable`, `RoomName`, `RoomType`, `Capacity`) VALUES
(3, 'MC', 'McDermott Library', '3.442', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Alamo', 'Study Room', 4),
(4, 'MC', 'McDermott Library', '3.618', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Bluebonnet', 'Study Room', 6),
(5, 'MC', 'McDermott Library', '3.710', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Honeybee', 'Study Room', 8),
(6, 'MC', 'McDermott Library', '3.444', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Longhorn', 'Study Room', 4),
(7, 'MC', 'McDermott Library', '3.708', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Mesquite', 'Study Room', 8),
(8, 'MC', 'McDermott Library', '3.620', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Mockingbird', 'Study Room', 5),
(9, 'MC', 'McDermott Library', '3.614', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Pinto', 'Study Room', 2),
(10, 'MC', 'McDermott Library', '2.520', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Prickly Pear', 'Study Room', 4),
(11, 'MC', 'McDermott Library', '3.236', 'Mon-Thu 7AM–2AM | Fri 7AM–8PM | Sat-Sun 11AM–8PM', 'Topaz', 'Study Room', 4);

-- --------------------------------------------------------
-- Table structure for table `TutorCourses`
-- --------------------------------------------------------

CREATE TABLE `TutorCourses` (
  `TutorIndex` int NOT NULL,
  `CourseIndex` int NOT NULL,
  PRIMARY KEY (`TutorIndex`,`CourseIndex`),
  CONSTRAINT `fk_tutorcourses_tutor`
    FOREIGN KEY (`TutorIndex`) REFERENCES `Tutors`(`TutorIndex`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_tutorcourses_course`
    FOREIGN KEY (`CourseIndex`) REFERENCES `Courses`(`CourseIndex`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `TutorCourses`
--

INSERT INTO `TutorCourses` (`TutorIndex`, `CourseIndex`) VALUES
(1, 1426),
(1, 1427),
(1, 1428),
(2, 1426),
(2, 1429);

-- --------------------------------------------------------
-- Table structure for table `Lessons`
-- --------------------------------------------------------

CREATE TABLE `Lessons` (
  `LessonID` int NOT NULL,
  `StudentIndex` int NOT NULL,
  `TutorIndex` int NOT NULL,
  `LocationIndex` int NOT NULL,
  `CourseIndex` int DEFAULT NULL,
  `Topic` varchar(255) DEFAULT NULL,
  `LessonDate` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Duration` int NOT NULL,
  `Status` varchar(20) NOT NULL,
  PRIMARY KEY (`LessonID`),
  KEY `StudentIndex` (`StudentIndex`),
  KEY `lessons_ibfk_2` (`TutorIndex`),
  KEY `lessons_ibfk_3` (`LocationIndex`),
  KEY `lessons_ibfk_4` (`CourseIndex`),
  CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`StudentIndex`) REFERENCES `Students` (`StudentIndex`) ON DELETE CASCADE,
  CONSTRAINT `lessons_ibfk_2` FOREIGN KEY (`TutorIndex`) REFERENCES `Tutors` (`TutorIndex`) ON DELETE CASCADE,
  CONSTRAINT `lessons_ibfk_3` FOREIGN KEY (`LocationIndex`) REFERENCES `Locations` (`LocationIndex`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `lessons_ibfk_4` FOREIGN KEY (`CourseIndex`) REFERENCES `Courses` (`CourseIndex`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Lessons`
--

INSERT INTO `Lessons` (`LessonID`, `StudentIndex`, `TutorIndex`, `LocationIndex`, `CourseIndex`, `Topic`, `LessonDate`, `StartTime`, `EndTime`, `Duration`, `Status`) VALUES
(1, 1002, 2, 3, 1429, NULL, '2026-05-01', '14:00:00', '14:20:00', 20, 'Upcoming');

COMMIT;

 /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;