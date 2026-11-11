-- ==============================================================
-- HSE INDUCTION MODULE - VISITOR REGISTRATION & CLEARANCE SCHEMA
-- ==============================================================
-- Table: hse_visitor_registration
-- Description: Stores public visitor registrations, HSSE approval workflow,
--              6-digit OTP codes, tokenized assessment access, video view progress,
--              score, validity date, QR pass path, and certificate details.
-- ==============================================================

CREATE TABLE IF NOT EXISTS `hse_visitor_registration` (
  `VISITOR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `VISITOR_REG_NO` varchar(50) NOT NULL COMMENT 'Unique Registration Reference e.g. LMT-VIS-20261105-0001',
  `COMPANY_NAME` varchar(255) NOT NULL,
  `VISITOR_NAME` varchar(255) NOT NULL,
  `IC_PASSPORT_NO` varchar(100) NOT NULL,
  `VEHICLE_DETAIL` varchar(100) DEFAULT NULL,
  `EMAIL_ID` varchar(255) NOT NULL,
  `PHONE_NO` varchar(50) NOT NULL,
  `ADDRESS` text NOT NULL,
  `VISIT_PURPOSE` text NOT NULL,
  `VISIT_DATETIME` datetime NOT NULL,
  `VISIT_DATETIME_END` datetime DEFAULT NULL COMMENT 'Visit Period End Date & Time (Defines Certificate Validity Due Date)',
  `TERMINAL_ID` int(11) NOT NULL COMMENT 'FK to TERMINAL_MANAGEMENT (TER_AUTO_ID)',
  `CONTACT_PERSON_ID` int(11) DEFAULT NULL COMMENT 'FK to EMPLOYEE_MANAGEMENT (EMP_AUTO_ID) Host Contact',
  `CONTACT_PERSON_NAME` varchar(255) DEFAULT NULL,
  `PDPA_AGREED` enum('Y','N') NOT NULL DEFAULT 'Y',
  `APPROVAL_STATUS` enum('PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'PENDING',
  `APPROVED_BY` int(11) DEFAULT NULL,
  `APPROVED_ON` datetime DEFAULT NULL,
  `REJECTION_REASON` text DEFAULT NULL,
  `OTP_CODE` varchar(10) DEFAULT NULL,
  `OTP_CREATED_AT` datetime DEFAULT NULL,
  `OTP_EXPIRES_AT` datetime DEFAULT NULL,
  `OTP_VERIFIED` enum('Y','N') NOT NULL DEFAULT 'N',
  `ACCESS_TOKEN` varchar(64) NOT NULL COMMENT 'Unique SHA-256 access token for public OTP & exam URLs',
  `INDUCTION_STATUS` enum('NOT_STARTED','IN_PROGRESS','PASSED','FAILED','EXPIRED') NOT NULL DEFAULT 'NOT_STARTED',
  `VIDEO_STATUS` enum('NOT_WATCHED','WATCHING','COMPLETED') NOT NULL DEFAULT 'NOT_WATCHED',
  `VIDEO_WATCHED_SECONDS` int(11) DEFAULT 0,
  `SCORE_PERCENTAGE` decimal(5,2) DEFAULT 0.00,
  `TOTAL_QUESTIONS` int(11) DEFAULT 0,
  `CORRECT_ANSWERS` int(11) DEFAULT 0,
  `WRONG_ANSWERS` int(11) DEFAULT 0,
  `ATTEMPTS_COUNT` int(11) DEFAULT 0,
  `CERTIFICATE_NO` varchar(100) DEFAULT NULL,
  `QR_CODE_PATH` varchar(255) DEFAULT NULL,
  `PASSED_DATE` datetime DEFAULT NULL,
  `VALIDITY_DATE` date DEFAULT NULL,
  `IP_ADDRESS` varchar(45) DEFAULT NULL,
  `STATUS` enum('Y','N') NOT NULL DEFAULT 'Y',
  `CREATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATED_ON` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`VISITOR_ID`),
  UNIQUE KEY `UK_VISITOR_REG_NO` (`VISITOR_REG_NO`),
  UNIQUE KEY `UK_ACCESS_TOKEN` (`ACCESS_TOKEN`),
  KEY `IDX_APPROVAL_STATUS` (`APPROVAL_STATUS`),
  KEY `IDX_INDUCTION_STATUS` (`INDUCTION_STATUS`),
  KEY `IDX_VISIT_DATETIME` (`VISIT_DATETIME`),
  KEY `IDX_TERMINAL_ID` (`TERMINAL_ID`),
  KEY `IDX_CONTACT_PERSON` (`CONTACT_PERSON_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ==============================================================
-- MENU & PERMISSION MASTER SETUP
-- Menu entry available under HSE Induction; data visibility controlled in controller
-- (Super Admin & HSSE view all visitor records; other user roles see empty table)
-- ==============================================================

-- Ensure Visitor menu entry under HSE Induction (MENU_PARENT_ID = 88)
INSERT INTO `left_menu` (`MENU_ID`, `MENU_NAME`, `MENUNAME_KEY`, `MENU_LINK`, `MENU_ICON`, `MENU_IS_PARENT`, `MENU_PARENT_ID`, `MENU_IS_MODULE`, `MENU_MODULE_KEY`, `MENU_SORT_ORDER`, `MENU_STATUS`)
VALUES (95, 'Visitor', 'visitor', 'hse_induction/visitor', 'fas fa-id-card-alt', 0, 88, 0, 'visitor', 4, 'Y')
ON DUPLICATE KEY UPDATE `MENU_NAME` = VALUES(`MENU_NAME`), `MENU_LINK` = VALUES(`MENU_LINK`), `MENU_STATUS` = 'Y';

-- Configure permissions matching other induction modules (e.g. Employee, Contractor)
INSERT INTO `permission_master` (`DESIGNATION_ID`, `MENU_ID`, `ADD_PER`, `EDIT_PER`, `DEL_PER`, `VIEW_PER`, `PRINT_PER`, `PERMISSION_STATUS`)
VALUES 
  (0, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (1, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (2, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (3, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (4, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (5, 95, 'Y', 'Y', 'Y', 'N', 'Y', 'Y'),
  (6, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (7, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (8, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (9, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (10, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (11, 95, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y')
ON DUPLICATE KEY UPDATE `VIEW_PER` = VALUES(`VIEW_PER`), `ADD_PER` = VALUES(`ADD_PER`), `EDIT_PER` = VALUES(`EDIT_PER`), `DEL_PER` = VALUES(`DEL_PER`), `PRINT_PER` = VALUES(`PRINT_PER`), `PERMISSION_STATUS` = 'Y';



