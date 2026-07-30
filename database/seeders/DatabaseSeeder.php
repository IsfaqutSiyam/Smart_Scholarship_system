<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Scholarship;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────────────
        User::create([
            'full_name'    => 'Admin User',
            'email'        => 'admin@scholarify.bd',
            'password_hash'=> Hash::make('password'),
            'role'         => 'admin',
            'plan'         => 'premium',
        ]);
        User::create([
            'full_name'           => 'Rahima Begum',
            'email'               => 'student@scholarify.bd',
            'password_hash'       => Hash::make('password'),
            'role'                => 'student',
            'plan'                => 'free',
            'academic_background' => 'HSC from Dhaka College, 2023',
            'preferred_field'     => 'Computer Science',
            'cgpa'                => 3.70,
            'language_proficiency'=> 'IELTS 6.5',
            'degree_seeking'      => 'bachelor',
        ]);

        // ── Universities ──────────────────────────────────────
        // Format: [name, city, province, tier, lang, year, web, desc]
        $unis = [

            // ── NORTH CHINA ──────────────────────────────────
            ['Peking University',               'Beijing',  'Beijing',      '985',               'English',  1898, 'https://www.pku.edu.cn',
             "China's most prestigious university. Broad English-medium programs for international students in science, engineering, humanities, and medicine."],
            ['Tsinghua University',             'Beijing',  'Beijing',      '985',               'English',  1911, 'https://www.tsinghua.edu.cn',
             "China's top engineering and technology university, consistently ranked in the global top 20. Strong in STEM, architecture, and economics."],
            ['Renmin University of China',      'Beijing',  'Beijing',      '985',               'English',  1937, 'https://www.ruc.edu.cn',
             'Premier university for social sciences, economics, law, and humanities. Strong reputation in politics and public administration.'],
            ['Beijing Institute of Technology', 'Beijing',  'Beijing',      '211',               'English',  1940, 'https://www.bit.edu.cn',
             'Leading national university in defense science and technology. Excellent programs in engineering, computer science, and management.'],
            ['Beijing Normal University',       'Beijing',  'Beijing',      '985',               'Bilingual',1902, 'https://www.bnu.edu.cn',
             'China\'s top teacher-training and education research university. Strong in psychology, Chinese language, and education sciences.'],
            ['Nankai University',               'Tianjin',  'Tianjin',      '985',               'English',  1919, 'https://www.nankai.edu.cn',
             'Comprehensive research university in Tianjin. Strong in chemistry, economics, history, and mathematics.'],
            ['Tianjin University',              'Tianjin',  'Tianjin',      '985',               'English',  1895, 'https://www.tju.edu.cn',
             'China\'s first modern university. Renowned for engineering, architecture, chemical engineering, and management.'],
            ['Hebei University of Technology',  'Tianjin',  'Hebei',        '211',               'Bilingual',1903, 'https://www.hebut.edu.cn',
             'Strong engineering university in North China. Programs in mechanical engineering, electrical engineering, and material science.'],

            // ── NORTHEAST CHINA ───────────────────────────────
            ['Jilin University',                'Changchun','Jilin',         '985',               'Bilingual',1946, 'https://www.jlu.edu.cn',
             'One of China\'s largest comprehensive universities. Excellent programs in automotive engineering, chemistry, and medicine.'],
            ['Harbin Institute of Technology',  'Harbin',   'Heilongjiang',  '985',               'English',  1920, 'https://www.hit.edu.cn',
             'Top-ranked C9 League engineering university. World-class programs in aerospace, computer science, and robotics.'],
            ['Harbin Engineering University',   'Harbin',   'Heilongjiang',  '211',               'Bilingual',1953, 'https://www.hrbeu.edu.cn',
             'Strong in naval architecture, marine engineering, and nuclear engineering. Great choice for engineering students.'],
            ['Northeastern University',         'Shenyang', 'Liaoning',      '985',               'English',  1923, 'https://www.neu.edu.cn',
             'Leading university in metallurgy, materials science, and information science. Strong industry connections in Northeast China.'],
            ['Dalian University of Technology', 'Dalian',   'Liaoning',      '985',               'English',  1949, 'https://www.dlut.edu.cn',
             'Coastal engineering university with strong programs in chemical engineering, civil engineering, and ocean technology.'],
            ['Dalian Maritime University',      'Dalian',   'Liaoning',      '211',               'English',  1909, 'https://www.dlmu.edu.cn',
             'China\'s leading maritime university. Top choice for navigation, marine engineering, and port management.'],

            // ── EAST CHINA ────────────────────────────────────
            ['Fudan University',                'Shanghai', 'Shanghai',      '985',               'English',  1905, 'https://www.fudan.edu.cn',
             'World-class comprehensive research university in Shanghai. Outstanding programs in medicine, science, economics, and law.'],
            ['Shanghai Jiao Tong University',   'Shanghai', 'Shanghai',      '985',               'English',  1896, 'https://www.sjtu.edu.cn',
             'Leading C9 research university. Globally ranked for engineering, medicine, and business. Strong MIT partnership.'],
            ['Tongji University',               'Shanghai', 'Shanghai',      '985',               'English',  1907, 'https://www.tongji.edu.cn',
             'Germany-connected university famous for architecture, civil engineering, automotive engineering, and environmental science.'],
            ['East China Normal University',    'Shanghai', 'Shanghai',      '985',               'Bilingual',1951, 'https://www.ecnu.edu.cn',
             'Premier education and social sciences university in Shanghai. Strong in psychology, mathematics, and geography.'],
            ['Zhejiang University',             'Hangzhou', 'Zhejiang',      '985',               'English',  1897, 'https://www.zju.edu.cn',
             'One of China\'s oldest and most comprehensive universities. Outstanding in agriculture, engineering, medicine, and computing.'],
            ['Nanjing University',              'Nanjing',  'Jiangsu',       '985',               'English',  1902, 'https://www.nju.edu.cn',
             'C9 League university in East China. Excellent reputation in physics, chemistry, geology, astronomy, and humanities.'],
            ['Southeast University',            'Nanjing',  'Jiangsu',       '985',               'English',  1902, 'https://www.seu.edu.cn',
             'Top engineering university in East China. Strong in architecture, transportation, electronics, and biomedical engineering.'],
            ['Nanjing University of Sci & Tech', 'Nanjing', 'Jiangsu',      '211',               'English',  1953, 'https://www.njust.edu.cn',
             'Specialized in engineering and technology. Programs in computer science, materials science, chemical engineering, and management.'],
            ['University of Science & Tech China','Hefei',  'Anhui',         '985',               'English',  1958, 'https://www.ustc.edu.cn',
             'Elite science university (CAS). Exceptional in physics, quantum information, mathematics, and computer science.'],
            ['Shandong University',             'Jinan',    'Shandong',      '985',               'Bilingual',1901, 'https://www.sdu.edu.cn',
             'Comprehensive university with 120+ year history. Excellent in Chinese language & culture, medicine, chemistry, and law.'],
            ['Xiamen University',               'Xiamen',   'Fujian',        '985',               'English',  1921, 'https://www.xmu.edu.cn',
             'Beautiful coastal university in Southeast China. Strong in economics, finance, chemistry, marine science, and Taiwan studies.'],

            // ── CENTRAL CHINA ─────────────────────────────────
            ['Wuhan University',                'Wuhan',    'Hubei',         '985',               'English',  1893, 'https://www.whu.edu.cn',
             'Comprehensive C9 university in Central China. World leader in remote sensing. Strong in law, information management, and medicine.'],
            ['Huazhong Univ of Sci & Technology','Wuhan',   'Hubei',         '985',               'Bilingual',1952, 'https://www.hust.edu.cn',
             'Major science and technology university. Excellent for mechanical engineering, biomedical engineering, and public administration.'],
            ['Wuhan University of Technology',  'Wuhan',    'Hubei',         '211',               'English',  1948, 'https://www.whut.edu.cn',
             'Strong in materials science, transportation, and mechanical engineering. Good scholarship opportunities.'],
            ['Central South University',        'Changsha', 'Hunan',         '985',               'Bilingual',2000, 'https://www.csu.edu.cn',
             'China\'s top university for mining, metallurgy, and materials science. Also excellent for medicine and civil engineering.'],
            ['Hunan University',                'Changsha', 'Hunan',         '985',               'English',  1903, 'https://www.hnu.edu.cn',
             'One of China\'s oldest higher education institutions. Strong in engineering, business, architecture, and finance.'],
            ['Zhengzhou University',            'Zhengzhou','Henan',          'Double First Class','Bilingual',1956, 'https://www.zzu.edu.cn',
             'Largest university in Central China by enrollment. Strong programs in engineering, medicine, and materials science.'],

            // ── SOUTH CHINA ───────────────────────────────────
            ['Sun Yat-sen University',          'Guangzhou','Guangdong',     '985',               'English',  1924, 'https://www.sysu.edu.cn',
             'Comprehensive research university in South China. Excellent in medicine, life sciences, chemistry, and social sciences.'],
            ['South China Univ of Technology',  'Guangzhou','Guangdong',     '985',               'English',  1952, 'https://www.scut.edu.cn',
             'Top engineering university in South China. Outstanding for computer science, electronic engineering, and light industry.'],
            ['Jinan University',                'Guangzhou','Guangdong',     '211',               'English',  1906, 'https://www.jnu.edu.cn',
             'Oldest overseas Chinese university. Popular with international students. Strong in medicine, business, and communication.'],
            ['Guangxi University',              'Nanning',  'Guangxi',       'Double First Class','Mandarin', 1928, 'https://www.gxu.edu.cn',
             'Comprehensive university in the Guangxi Zhuang Autonomous Region. Popular with ASEAN students. Gateway to Southeast Asia.'],
            ['Hainan University',               'Haikou',   'Hainan',        'Double First Class','English',  1983, 'https://www.hainu.edu.cn',
             'Located on tropical Hainan Island. Programs in marine science, agriculture, tourism, and finance. Free Trade Zone opportunities.'],

            // ── SOUTHWEST CHINA ───────────────────────────────
            ['Sichuan University',              'Chengdu',  'Sichuan',       '985',               'Bilingual',1896, 'https://www.scu.edu.cn',
             'Comprehensive national university. Best dentistry in China. Also strong in medicine, engineering, light industry, and humanities.'],
            ['University of Electronic Sci & Tech China','Chengdu','Sichuan','985',               'English',  1956, 'https://www.uestc.edu.cn',
             'China\'s top university for electronic science and technology. Excellent for EE, telecommunications, and computer engineering.'],
            ['Chongqing University',            'Chongqing','Chongqing',     '985',               'English',  1929, 'https://www.cqu.edu.cn',
             'Major engineering university in Southwest China. Strong in electrical engineering, civil engineering, and architecture.'],
            ['Southwest University',            'Chongqing','Chongqing',     '211',               'Bilingual',2005, 'https://www.swu.edu.cn',
             'Strong in agriculture, sericulture, and food science. Beautiful campus. Good scholarship options for international students.'],
            ['Yunnan University',               'Kunming',  'Yunnan',        'Double First Class','Mandarin', 1922, 'https://www.ynu.edu.cn',
             'Gateway to Southeast Asian studies. Strong in ecology, ethnology, and agriculture. Kunming has the best climate in China.'],
            ['Guizhou University',              'Guiyang',  'Guizhou',       'Double First Class','Mandarin', 1902, 'https://www.gzu.edu.cn',
             'Comprehensive university in Guizhou Province. Programs in mining, big data, agriculture, and ethnic culture studies.'],

            // ── NORTHWEST CHINA ───────────────────────────────
            ["Xi'an Jiaotong University",       "Xi'an",    'Shaanxi',       '985',               'English',  1896, 'https://www.xjtu.edu.cn',
             "C9 League university in Northwest China. Excellent for engineering, medicine, management, and energy science."],
            ['Northwestern Polytechnical Univ', "Xi'an",    'Shaanxi',       '985',               'English',  1938, 'https://www.nwpu.edu.cn',
             'China\'s top university for aerospace, navigation, and marine engineering. Strong defense science and technology programs.'],
            ['Shaanxi Normal University',       "Xi'an",    'Shaanxi',       '211',               'Bilingual',1944, 'https://www.snnu.edu.cn',
             'Premier teacher-training university in Northwest China. Strong in Chinese language, history, and education.'],
            ['Lanzhou University',              'Lanzhou',  'Gansu',         '985',               'Bilingual',1909, 'https://www.lzu.edu.cn',
             'Comprehensive research university in Western China. Unique strengths in geology, ecology, physics, and ethnic minority studies.'],
            ['Xinjiang University',             'Urumqi',   'Xinjiang',      'Double First Class','Bilingual',1924, 'https://www.xju.edu.cn',
             'Comprehensive university on the Silk Road. Programs in Chinese language, information science, mining, and Central Asian studies.'],
            ['Northwest A&F University',        'Yangling', 'Shaanxi',       '985',               'English',  1934, 'https://www.nwsuaf.edu.cn',
             'China\'s top agricultural university in Northwest China. Excellent for agronomy, horticulture, food science, and water conservancy.'],
        ];

        $uniModels = [];
        foreach ($unis as [$name,$city,$province,$tier,$lang,$year,$web,$desc]) {
            $region = University::regionForProvince($province);
            $uniModels[$name] = University::create([
                'university_name'         => $name,
                'city'                    => $city,
                'province'                => $province,
                'region'                  => $region,
                'ranking_tier'            => $tier,
                'language_of_instruction' => $lang,
                'established_year'        => $year,
                'website_url'             => $web,
                'description'             => $desc,
                'is_active'               => true,
            ]);
        }

        // ── Programs ──────────────────────────────────────────
        // [uni, name, level, field, duration, fee, lang_req, min_cgpa, deadline, guidance]
        $programs = [
            // Peking University
            ['Peking University','Computer Science and Technology','bachelor','Computer Science','4 years','¥28,000/yr','IELTS 6.0',3.50,'2026-03-15',
             "Documents: Passport · Transcripts (notarized) · Personal Statement (800 words) · 2 Recommendation Letters · IELTS/TOEFL\nApply via PKU International Portal. Application fee CNY 400. Results in 4-6 weeks."],
            ['Peking University','Medicine (MBBS)','bachelor','Medicine','6 years','¥45,000/yr','IELTS 6.5',3.70,'2026-02-28',
             "Documents: Passport · Transcripts (Biology+Chemistry required) · Physical Exam · HIV/Hepatitis B test · Personal Statement · IELTS 6.5\nPhone interview required. Min CGPA 3.7."],
            ['Peking University','International Economics and Trade','bachelor','Business','4 years','¥28,000/yr','IELTS 6.0',3.40,'2026-03-15',
             "Documents: Passport · Transcripts · Personal Statement · 2 Reference Letters · IELTS 6.0"],
            ['Peking University','Software Engineering','master','Computer Science','2-3 years','¥32,000/yr','IELTS 6.5',3.60,'2026-04-30',
             "Documents: Bachelor degree · Research Proposal (1500 words) · 2 Academic References · CV · English certificate"],

            // Tsinghua University
            ['Tsinghua University','Electronic Engineering','bachelor','Engineering','4 years','¥30,000/yr','IELTS 6.0',3.60,'2026-03-01',
             "Documents: Passport · Transcripts (Math+Physics required) · Personal Statement · 2 Reference Letters · IELTS\nStrong Mathematics background essential."],
            ['Tsinghua University','Mechanical Engineering','bachelor','Engineering','4 years','¥30,000/yr','IELTS 6.0',3.50,'2026-03-01',
             "Documents: Passport · Transcripts · Personal Statement · Reference Letters · IELTS"],
            ['Tsinghua University','Computer Science and Technology','master','Computer Science','2 years','¥32,000/yr','IELTS 6.5',3.60,'2026-04-15',
             "Documents: Bachelor degree · Transcripts · Research Proposal · 2 Reference Letters · IELTS"],
            ['Tsinghua University','Architecture','bachelor','Architecture','5 years','¥35,000/yr','IELTS 6.0',3.50,'2026-03-01',
             "Documents: Portfolio of design work · Passport · Transcripts · Personal Statement · IELTS\nPortfolio is mandatory for this program."],

            // Fudan University
            ['Fudan University','Software Engineering','bachelor','Computer Science','4 years','¥26,000/yr','IELTS 6.0',3.40,'2026-03-31',
             "Documents: Passport · High School Certificate+Transcripts · Personal Statement · 2 Reference Letters · IELTS\nEnglish-medium program."],
            ['Fudan University','Business Administration (MBA)','master','Business','2 years','¥80,000/yr','IELTS 6.5',3.20,'2026-05-31',
             "Documents: Bachelor degree · Work experience proof (2+ years) · GMAT (optional) · 2 Professional References · IELTS"],
            ['Fudan University','Public Health','master','Medicine','2 years','¥28,000/yr','IELTS 6.0',3.30,'2026-04-30',
             "Documents: Application form · Transcripts · Personal statement · 2 Academic references · IELTS"],

            // Zhejiang University
            ['Zhejiang University','Agricultural Science','bachelor','Agriculture','4 years','¥22,000/yr','IELTS 5.5',3.00,'2026-04-15',
             "Documents: Passport · High School Certificate · Transcripts · Personal Statement · IELTS\nScholarships widely available for this program."],
            ['Zhejiang University','Computer Science and Technology','bachelor','Computer Science','4 years','¥28,000/yr','IELTS 6.0',3.50,'2026-03-31',
             "Documents: Passport · Transcripts · Personal Statement · Reference Letters · IELTS"],
            ['Zhejiang University','Civil Engineering','master','Engineering','3 years','¥26,000/yr','IELTS 6.0',3.20,'2026-05-15',
             "Documents: Bachelor degree · Transcripts · Research Proposal · Reference Letters · IELTS"],

            // SJTU
            ['Shanghai Jiao Tong University','Electrical Engineering','bachelor','Engineering','4 years','¥28,000/yr','IELTS 6.0',3.50,'2026-03-15',
             "Documents: Passport · Transcripts · Personal Statement · Reference Letters · IELTS"],
            ['Shanghai Jiao Tong University','Biomedical Engineering','master','Engineering','3 years','¥30,000/yr','IELTS 6.5',3.40,'2026-04-30',
             "Documents: Bachelor degree · Research Proposal · 2 Reference Letters · IELTS"],
            ['Shanghai Jiao Tong University','Medicine (MBBS)','bachelor','Medicine','6 years','¥48,000/yr','IELTS 6.5',3.70,'2026-02-28',
             "Documents: Passport · Biology+Chemistry transcripts · Physical exam · HIV/Hepatitis test · IELTS 6.5"],

            // Tongji
            ['Tongji University','Architecture','bachelor','Architecture','5 years','¥26,000/yr','IELTS 5.5',3.20,'2026-04-30',
             "Documents: Portfolio · Passport · Transcripts · Personal Statement · IELTS\nGermany exchange program available for top students."],
            ['Tongji University','Civil Engineering','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.00,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],
            ['Tongji University','Environmental Science','master','Science','3 years','¥24,000/yr','IELTS 6.0',3.10,'2026-05-15',
             "Documents: Bachelor degree · Transcripts · Research Proposal · References · IELTS"],

            // Wuhan University
            ['Wuhan University','Remote Sensing Science and Technology','bachelor','Engineering','4 years','¥20,000/yr','IELTS 5.5',3.00,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nWHU is the global leader in remote sensing research."],
            ['Wuhan University','Computer Science','bachelor','Computer Science','4 years','¥22,000/yr','IELTS 5.5',3.00,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],
            ['Wuhan University','Law (LLB)','bachelor','Arts & Humanities','4 years','¥18,000/yr','HSK 5',3.10,'2026-04-30',
             "Documents: Passport · Transcripts · HSK 5 Certificate · Personal Statement\nNote: Taught in Mandarin. HSK Level 5 required."],

            // HUST
            ['Huazhong Univ of Sci & Technology','Mechanical Engineering','bachelor','Engineering','4 years','¥20,000/yr','IELTS 5.5',3.00,'2026-05-01',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],
            ['Huazhong Univ of Sci & Technology','Biomedical Engineering','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.10,'2026-05-01',
             "Documents: Passport · Transcripts (Biology/Chemistry required) · Personal Statement · IELTS"],

            // Harbin IT
            ['Harbin Institute of Technology','Software Engineering','bachelor','Computer Science','4 years','¥20,000/yr','IELTS 5.5',3.00,'2026-05-15',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nHIT is a C9 League university. Very affordable tuition."],
            ['Harbin Institute of Technology','Aerospace Engineering','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.20,'2026-05-15',
             "Documents: Passport · Transcripts (Math+Physics required) · Personal Statement · IELTS"],

            // Sun Yat-sen
            ['Sun Yat-sen University','Medicine (MBBS)','bachelor','Medicine','6 years','¥40,000/yr','IELTS 6.5',3.60,'2026-03-31',
             "Documents: Passport · Transcripts (Biology+Chemistry) · Medical exam · HIV/Hepatitis test · IELTS 6.5"],
            ['Sun Yat-sen University','Business Administration','bachelor','Business','4 years','¥24,000/yr','IELTS 6.0',3.20,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],

            // SCUT
            ['South China Univ of Technology','Computer Science and Technology','bachelor','Computer Science','4 years','¥22,000/yr','IELTS 5.5',3.10,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nLocated in Guangzhou's technology hub. Strong industry links."],
            ['South China Univ of Technology','Electronic Engineering','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.00,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],

            // Central South University
            ['Central South University','Mining Engineering','bachelor','Engineering','4 years','¥18,000/yr','IELTS 5.5',2.80,'2026-05-31',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nCSU is China's top university for mining and metallurgy."],
            ['Central South University','Medicine (Clinical Medicine)','bachelor','Medicine','6 years','¥35,000/yr','None',3.00,'2026-05-31',
             "Documents: Passport · Transcripts · Medical exam · Personal Statement\nEnglish-medium MBBS program."],

            // Sichuan University
            ['Sichuan University','Dentistry','bachelor','Medicine','5 years','¥35,000/yr','IELTS 6.0',3.20,'2026-05-31',
             "Documents: Passport · Transcripts (Biology+Chemistry) · Physical exam · IELTS\nSCU has the best Dentistry program in China."],
            ['Sichuan University','Computer Science','bachelor','Computer Science','4 years','¥20,000/yr','IELTS 5.5',3.00,'2026-05-31',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],

            // UESTC
            ['University of Electronic Sci & Tech China','Electronic Engineering','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.10,'2026-05-01',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nUESTc is China's best university for electronics and telecommunications."],
            ['University of Electronic Sci & Tech China','Computer Science','bachelor','Computer Science','4 years','¥22,000/yr','IELTS 5.5',3.10,'2026-05-01',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],
            ['University of Electronic Sci & Tech China','Telecommunications Engineering','master','Engineering','3 years','¥24,000/yr','IELTS 6.0',3.20,'2026-05-15',
             "Documents: Bachelor degree · Research Proposal · Reference Letters · IELTS"],

            // Chongqing University
            ['Chongqing University','Civil Engineering','bachelor','Engineering','4 years','¥18,000/yr','IELTS 5.5',2.80,'2026-05-31',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nAffordable tuition in a vibrant city."],
            ['Chongqing University','Architecture','bachelor','Architecture','5 years','¥20,000/yr','IELTS 5.5',3.00,'2026-05-31',
             "Documents: Portfolio · Passport · Transcripts · Personal Statement · IELTS"],

            // Yunnan University
            ['Yunnan University','Agriculture and Forestry','bachelor','Agriculture','4 years','¥15,000/yr','HSK 4',2.50,'2026-06-30',
             "Documents: Passport · Transcripts · HSK 4 Certificate · Personal Statement\nLower entry requirements. Kunming has excellent year-round climate."],
            ['Yunnan University','International Relations','master','Arts & Humanities','2 years','¥18,000/yr','IELTS 5.5',3.00,'2026-06-30',
             "Documents: Bachelor degree · Transcripts · Personal Statement · 2 Reference Letters · IELTS"],

            // Guangxi University
            ['Guangxi University','Agricultural Engineering','bachelor','Agriculture','4 years','¥14,000/yr','HSK 4',2.50,'2026-06-30',
             "Documents: Passport · Transcripts · HSK 4 Certificate · Personal Statement"],
            ['Guangxi University','Business Management','bachelor','Business','4 years','¥16,000/yr','None',2.50,'2026-06-30',
             "Documents: Passport · Transcripts · Personal Statement\nEnglish-medium. No Chinese language requirement."],

            // Xi'an JTU
            ["Xi'an Jiaotong University",'Mechanical Engineering','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.10,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nC9 League university in ancient Xi'an."],
            ["Xi'an Jiaotong University",'Energy and Power Engineering','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.00,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],
            ["Xi'an Jiaotong University",'Business Administration','master','Business','2 years','¥38,000/yr','IELTS 6.0',3.20,'2026-05-15',
             "Documents: Bachelor degree · Work experience (preferred) · GMAT (optional) · References · IELTS"],

            // Northwestern Polytechnical
            ['Northwestern Polytechnical Univ','Aerospace Engineering','bachelor','Engineering','4 years','¥20,000/yr','IELTS 5.5',3.20,'2026-05-01',
             "Documents: Passport · Transcripts (Math+Physics) · Personal Statement · IELTS\nTop university for aerospace in China."],
            ['Northwestern Polytechnical Univ','Software Engineering','bachelor','Computer Science','4 years','¥20,000/yr','IELTS 5.5',3.00,'2026-05-01',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],

            // Lanzhou University
            ['Lanzhou University','Chemistry','bachelor','Science','4 years','¥16,000/yr','IELTS 5.0',2.80,'2026-06-15',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nLocated on the ancient Silk Road. Unique Western China experience."],
            ['Lanzhou University','Environmental Science','bachelor','Science','4 years','¥16,000/yr','IELTS 5.0',2.80,'2026-06-15',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],

            // Northwest A&F University
            ['Northwest A&F University','Agronomy','bachelor','Agriculture','4 years','¥14,000/yr','IELTS 5.0',2.50,'2026-06-15',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nChina's top agricultural university. Many scholarships available."],
            ['Northwest A&F University','Food Science and Engineering','bachelor','Agriculture','4 years','¥14,000/yr','IELTS 5.0',2.50,'2026-06-15',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],

            // Nanjing University
            ['Nanjing University','Physics','bachelor','Science','4 years','¥22,000/yr','IELTS 6.0',3.40,'2026-04-15',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],
            ['Nanjing University','Software Engineering','master','Computer Science','3 years','¥26,000/yr','IELTS 6.0',3.20,'2026-05-15',
             "Documents: Bachelor degree · Research Proposal · References · IELTS"],

            // Southeast University
            ['Southeast University','Electronic Science and Technology','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.10,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],
            ['Southeast University','Architecture','bachelor','Architecture','5 years','¥24,000/yr','IELTS 5.5',3.20,'2026-04-30',
             "Documents: Portfolio · Passport · Transcripts · Personal Statement · IELTS"],

            // USTC
            ['University of Science & Tech China','Physics','bachelor','Science','4 years','¥26,000/yr','IELTS 6.0',3.60,'2026-03-31',
             "Documents: Passport · Transcripts (Math+Physics) · Personal Statement · References · IELTS\nElite science university. High admission standards."],
            ['University of Science & Tech China','Computer Science','bachelor','Computer Science','4 years','¥26,000/yr','IELTS 6.0',3.60,'2026-03-31',
             "Documents: Passport · Transcripts · Personal Statement · References · IELTS"],

            // Xiamen University
            ['Xiamen University','Finance and Economics','bachelor','Business','4 years','¥22,000/yr','IELTS 5.5',3.20,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nBeautiful coastal campus."],
            ['Xiamen University','Marine Science','bachelor','Science','4 years','¥22,000/yr','IELTS 5.5',3.00,'2026-04-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nChina's best marine science program."],

            // Dalian Maritime
            ['Dalian Maritime University','Navigation Technology','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.00,'2026-05-15',
             "Documents: Passport · Transcripts · Physical fitness exam · Personal Statement · IELTS\nChina's top maritime university."],
            ['Dalian Maritime University','Marine Engineering','bachelor','Engineering','4 years','¥22,000/yr','IELTS 5.5',3.00,'2026-05-15',
             "Documents: Passport · Transcripts · Physical fitness exam · Personal Statement · IELTS"],

            // Jilin University
            ['Jilin University','Automotive Engineering','bachelor','Engineering','4 years','¥20,000/yr','Bilingual',2.80,'2026-05-31',
             "Documents: Passport · Transcripts · Personal Statement · IELTS or HSK\nJLU has China's best automotive engineering program."],
            ['Jilin University','Medicine (Clinical)','bachelor','Medicine','6 years','¥32,000/yr','None',3.00,'2026-05-31',
             "Documents: Passport · Transcripts (Biology+Chemistry) · Medical exam · Personal Statement\nEnglish-medium MBBS."],

            // Northeastern University
            ['Northeastern University','Materials Science and Engineering','bachelor','Engineering','4 years','¥18,000/yr','IELTS 5.0',2.80,'2026-05-31',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nWorld-class materials science research."],
            ['Northeastern University','Computer Science','bachelor','Computer Science','4 years','¥18,000/yr','IELTS 5.0',2.80,'2026-05-31',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],

            // Hainan University
            ['Hainan University','Tourism Management','bachelor','Business','4 years','¥16,000/yr','IELTS 5.0',2.50,'2026-06-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nLocated on beautiful Hainan Island. Free Trade Zone access."],
            ['Hainan University','Marine Biology','bachelor','Science','4 years','¥16,000/yr','IELTS 5.0',2.50,'2026-06-30',
             "Documents: Passport · Transcripts · Personal Statement · IELTS"],

            // Jinan University
            ['Jinan University','Business Administration','bachelor','Business','4 years','¥20,000/yr','IELTS 5.5',3.00,'2026-05-31',
             "Documents: Passport · Transcripts · Personal Statement · IELTS\nPopular with international students. Strong Cantonese culture."],
            ['Jinan University','Chinese Medicine','bachelor','Medicine','5 years','¥22,000/yr','HSK 4',2.80,'2026-05-31',
             "Documents: Passport · Transcripts · HSK 4 Certificate · Medical exam · Personal Statement"],
        ];

        foreach ($programs as [$uniName,$name,$level,$field,$dur,$fee,$lang,$cgpa,$deadline,$guidance]) {
            if (isset($uniModels[$uniName])) {
                Program::create([
                    'university_id'        => $uniModels[$uniName]->university_id,
                    'program_name'         => $name,
                    'degree_level'         => $level,
                    'field_of_study'       => $field,
                    'duration'             => $dur,
                    'tuition_fee'          => $fee,
                    'language_requirement' => $lang,
                    'min_cgpa'             => $cgpa,
                    'application_deadline' => $deadline,
                    'application_guidance' => $guidance,
                    'is_active'            => true,
                ]);
            }
        }

        // ── Scholarships ──────────────────────────────────────
        $scholarships = [
            ['Peking University','Chinese Government Scholarship (CSC) — PKU','full',36000,'2026-02-28',3.50,'bachelor,master,phd',null,
             "Open to Bangladeshi students.\n- Min CGPA 3.5\n- Apply via CSC online portal\n- Under 25 (bachelor) or 35 (master/PhD)\n- Cannot hold another scholarship",
             "✓ Full tuition waiver\n✓ Stipend: ¥2,500 (bachelor) / ¥3,000 (master) / ¥3,500 (PhD)\n✓ On-campus accommodation\n✓ Medical insurance\n✓ One-time settlement allowance"],
            ['Tsinghua University','Tsinghua University Excellence Scholarship','partial',25000,'2026-03-15',3.60,'bachelor,master','Computer Science,Engineering',
             "For outstanding students in Engineering/CS.\n- Min CGPA 3.6\n- Priority for developing countries",
             "✓ 75% tuition reduction\n✓ Monthly stipend ¥2,000\n✓ One-time travel allowance ¥5,000"],
            ['Fudan University','Fudan International Student Scholarship','partial',20000,'2026-04-01',3.30,'bachelor,master',null,
             "Open to all international students.\n- Min CGPA 3.3\n- Must maintain 3.0 GPA to renew",
             "✓ 50% tuition waiver\n✓ Monthly allowance ¥1,500\n✓ Student dormitory"],
            ['Zhejiang University','Belt and Road Initiative Scholarship — ZJU','full',30000,'2026-03-31',3.00,'bachelor,master,phd',null,
             "For students from Belt and Road countries including Bangladesh.\n- Min CGPA 3.0\n- Apply through Chinese Embassy",
             "✓ Full tuition waiver\n✓ Stipend ¥2,500 (bachelor) / ¥3,000 (graduate)\n✓ Shared dormitory\n✓ Health insurance"],
            ['Wuhan University','Wuhan University President Scholarship','full',32000,'2026-04-15',3.40,'bachelor,master',null,
             "For academically outstanding students.\n- Min CGPA 3.4\n- Submit study plan",
             "✓ Full tuition waiver\n✓ ¥2,500 (bachelor) / ¥3,000 (master) allowance\n✓ Free accommodation\n✓ Medical insurance"],
            ['Shanghai Jiao Tong University','SJTU Full Scholarship for International Students','full',35000,'2026-03-01',3.50,'master,phd','Engineering,Computer Science',
             "For postgraduate students in Engineering/CS.\n- Min CGPA 3.5 (master) / 3.6 (PhD)\n- Research proposal required",
             "✓ Full tuition waiver\n✓ ¥3,000 (Master) / ¥3,500 (PhD) monthly\n✓ Free accommodation\n✓ Medical insurance\n✓ Settlement fee ¥1,500"],
            ['Harbin Institute of Technology','HIT International Student Scholarship','full',28000,'2026-05-01',3.00,'bachelor,master','Engineering,Computer Science',
             "For international students in Engineering/CS.\n- Min CGPA 3.0\n- Strong Math background",
             "✓ Full tuition waiver\n✓ ¥2,000 (bachelor) / ¥2,500 (master) monthly\n✓ Accommodation subsidy ¥600/month\n✓ Medical insurance"],
            ['Central South University','CSU Hunan Government Scholarship','full',24000,'2026-05-31',2.80,'bachelor,master',null,
             "Provincial government scholarship.\n- Min CGPA 2.8\n- Good health certificate\n- All fields eligible",
             "✓ Full tuition fee\n✓ Monthly stipend ¥2,000\n✓ Free dormitory\n✓ Medical insurance"],
            ['Sun Yat-sen University','SYSU International Medical Scholarship','partial',18000,'2026-03-15',3.50,'bachelor','Medicine',
             "For MBBS program students.\n- Min CGPA 3.5\n- Priority for South/Southeast Asia",
             "✓ 50% tuition reduction\n✓ Priority accommodation\n✓ Medical insurance\n✓ Lab fee waiver"],
            ['Sichuan University','SCU International Student Excellence Award','partial',15000,'2026-05-31',3.00,'bachelor,master',null,
             "Merit-based scholarship.\n- Min CGPA 3.0\n- Submit 500-word essay",
             "✓ ¥15,000 annual tuition reduction\n✓ Monthly allowance ¥800\n✓ Priority accommodation"],
            ['Guangxi University','Guangxi Government ASEAN Scholarship','full',20000,'2026-06-30',2.50,'bachelor,master',null,
             "For students from South and Southeast Asian countries including Bangladesh.\n- Min CGPA 2.5\n- Commit to learning Mandarin in Year 1",
             "✓ Full tuition waiver\n✓ Monthly stipend ¥2,000\n✓ Free accommodation\n✓ Travel allowance ¥3,000\n✓ Medical insurance"],
            ['Zhejiang University','ZJU Agriculture Program Scholarship','tuition_only',22000,'2026-04-15',2.80,'bachelor','Agriculture',
             "For agriculture students at ZJU.\n- Min CGPA 2.8\n- Preference for developing countries",
             "✓ Full tuition waiver\n✓ Lab and field trip fees included"],
            ["Xi'an Jiaotong University",'XJTU Silk Road Scholarship','full',26000,'2026-04-30',3.00,'bachelor,master,phd',null,
             "For students from Silk Road countries including Bangladesh.\n- Min CGPA 3.0\n- Apply through Chinese Embassy",
             "✓ Full tuition waiver\n✓ Monthly stipend ¥2,500\n✓ Accommodation\n✓ Medical insurance"],
            ['Tongji University','Tongji-Germany Exchange Scholarship','partial',20000,'2026-04-30',3.20,'master','Engineering,Architecture',
             "For graduate students in Engineering or Architecture.\n- Min CGPA 3.2\n- German language basics preferred",
             "✓ 60% tuition reduction\n✓ Monthly allowance ¥1,800\n✓ Priority for Germany exchange program"],
            ['Northwest A&F University','NwAFU Agriculture Scholarship','full',18000,'2026-06-15',2.50,'bachelor,master','Agriculture',
             "China's top agricultural university scholarship.\n- Min CGPA 2.5\n- For students from agricultural backgrounds",
             "✓ Full tuition waiver\n✓ Monthly stipend ¥2,000\n✓ Free accommodation\n✓ Medical insurance"],
            ['Dalian University of Technology','DUT Northeast China Scholarship','partial',16000,'2026-05-15',3.00,'bachelor,master','Engineering,Computer Science',
             "For students in Engineering and CS.\n- Min CGPA 3.0\n- Strong academic record",
             "✓ 50% tuition reduction\n✓ Monthly allowance ¥1,500\n✓ Accommodation discount"],
            ['University of Science & Tech China','USTC Elite Science Scholarship','full',32000,'2026-03-31',3.60,'bachelor,master,phd','Science,Computer Science',
             "For top science students.\n- Min CGPA 3.6\n- Exceptionally competitive\n- Research aptitude required",
             "✓ Full tuition waiver\n✓ Monthly stipend ¥3,000\n✓ Research lab access\n✓ Medical insurance"],
            ['Hainan University','Hainan Free Trade Zone Scholarship','full',16000,'2026-06-30',2.50,'bachelor',null,
             "For students interested in free trade and island economy.\n- Min CGPA 2.5\n- All majors eligible",
             "✓ Full tuition waiver\n✓ Monthly stipend ¥1,800\n✓ Accommodation\n✓ Internship opportunities in FTZ"],
        ];

        foreach ($scholarships as [$uniName,$sName,$type,$amt,$deadline,$minCgpa,$degrees,$fields,$criteria,$coverage]) {
            if (isset($uniModels[$uniName])) {
                Scholarship::create([
                    'university_id'          => $uniModels[$uniName]->university_id,
                    'scholarship_name'       => $sName,
                    'funding_type'           => $type,
                    'annual_amount_cny'      => $amt,
                    'application_deadline'   => $deadline,
                    'min_cgpa'               => $minCgpa,
                    'eligible_degree_levels' => $degrees,
                    'eligible_fields'        => $fields,
                    'eligibility_criteria'   => $criteria,
                    'coverage_details'       => $coverage,
                    'is_active'              => true,
                    'is_visible'             => true,
                ]);
            }
        }
    }
}
