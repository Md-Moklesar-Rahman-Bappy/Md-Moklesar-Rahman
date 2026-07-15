-- ============================================
-- SEED DATA — Md Moklesar Rahman Portfolio
-- Run after schema.sql
-- ============================================

-- ============================================
-- SITE SETTINGS
-- ============================================
insert into site_settings (site_name, owner_name, tagline, primary_email, phone, location)
values (
  'Md Moklesar Rahman',
  'Md Moklesar Rahman',
  'Web Designer & Developer',
  'md.moklasarrahmanbappy@gmail.com',
  '+880-161-6322779',
  'Ramnogor Mor, Dinajpur-5200, Bangladesh'
);

-- ============================================
-- HERO
-- ============================================
insert into hero (title, subtitle, description, cta_primary_label, cta_primary_url, cta_secondary_label, cta_secondary_url)
values (
  'Md Moklesar Rahman',
  'Web Designer & Developer',
  'Architect of custom WordPress themes and Laravel dashboards, blending modular UI/UX with joyful polish.',
  'Hire Me',
  '#contact',
  'Download CV',
  '/files/Md_Moklesar_Rahman.pdf'
);

-- ============================================
-- ABOUT
-- ============================================
insert into about (heading, content, years_experience)
values (
  'About Me',
  'I am a passionate Web Designer & Developer with experience building custom WordPress themes, Laravel dashboards, and modern web applications. Currently serving as an Assistant Maintenance Engineer at the Land Record & Survey Directorate, Dhaka. I blend modular UI/UX design with clean code to create joyful digital experiences.',
  5
);

-- ============================================
-- SKILLS
-- ============================================
insert into skills (name, category, level, sort_order) values
  ('WordPress', 'development', 85, 1),
  ('Web Development', 'development', 80, 2),
  ('Web Design', 'design', 75, 3),
  ('Graphics Design', 'design', 70, 4),
  ('Laravel', 'development', 70, 5),
  ('HTML/CSS', 'development', 90, 6),
  ('JavaScript', 'development', 75, 7),
  ('PHP', 'development', 75, 8),
  ('UI/UX Design', 'design', 70, 9),
  ('Elementor', 'tools', 80, 10);

-- ============================================
-- PROJECTS — Graphics Design
-- ============================================
insert into projects (title, slug, short_description, image_url, live_url, category, featured, sort_order) values
  ('Aaroter Dam Logo', 'aaroter-dam-logo', 'Brand identity design for Aaroter Dam', '/img/graphics/aaroterdam.png', 'https://www.behance.net/gallery/129724207/AaroterDamCom', 'graphics-design', false, 1),
  ('Blue Bird Fashion Logo', 'blue-bird-fashion-logo', 'Logo design for Blue Bird Fashion BD', '/img/graphics/bluebird.png', 'https://www.behance.net/gallery/129724519/Blue-Bird-Fashion-BD', 'graphics-design', false, 2),
  ('BD Sky News 24 Logo', 'bd-sky-news-logo', 'Brand identity for BD Sky News 24', '/img/graphics/bdskynews.png', 'https://www.behance.net/gallery/129724305/bdskyNews24com', 'graphics-design', false, 3),
  ('Chackbazar Dhaka Logo', 'chackbazar-dhaka-logo', 'Logo design for Chawkbazar Dhaka', '/img/graphics/chackbazar.png', 'https://www.behance.net/gallery/129724675/Chackbazardhakacom-Logo', 'graphics-design', false, 4),
  ('eStation Company Profile', 'estation-company-profile', 'Company profile mockup design for eStation Limited', '/img/graphics/estation.png', 'https://www.behance.net/gallery/129724803/eStation-Limited', 'graphics-design', false, 5),
  ('Genki Diaper Logo', 'genki-diaper-logo', 'Brand identity for Genki Baby Diapers', '/img/graphics/genki.png', 'https://www.behance.net/gallery/129724889/Genki-Baby-Diapers', 'graphics-design', false, 6),
  ('Kodomo Baby Care Logo', 'kodomo-baby-care-logo', 'Logo design for Kodomo Baby Care', '/img/graphics/kodomo.png', 'https://www.behance.net/gallery/129724953/Kodomo-Baby-Care', 'graphics-design', false, 7),
  ('Lion Baby Care New Logo', 'lion-baby-care-new', 'New brand identity for Lion Baby Care', '/img/graphics/lionnew.png', 'https://www.behance.net/gallery/129768671/Lion-Baby-Care-New-Logo', 'graphics-design', false, 8),
  ('Lion Baby Care Old Logo', 'lion-baby-care-old', 'Original logo for Lion Baby Care', '/img/graphics/lionold.png', 'https://www.behance.net/gallery/129725183/Lion-Baby-Care-Original-Logo', 'graphics-design', false, 9),
  ('Probe Bangladesh Logo', 'probe-bangladesh-logo', 'Brand identity for Probe Bangladesh', '/img/graphics/Probe.png', 'https://www.behance.net/gallery/85753059/PROBE-Bangladesh', 'graphics-design', false, 10);

-- ============================================
-- PROJECTS — Web Design & Development (placeholders for owner to update)
-- ============================================
insert into projects (title, slug, short_description, image_url, category, featured, sort_order) values
  ('Web Design Project 1', 'web-design-project-1', 'Update this with your actual project details', '/img/portfolio-1.jpg', 'web-design', false, 11),
  ('Web Design Project 2', 'web-design-project-2', 'Update this with your actual project details', '/img/portfolio-2.jpg', 'web-design', false, 12),
  ('Web Development Project 1', 'web-dev-project-1', 'Update this with your actual project details', '/img/portfolio-3.jpg', 'web-development', false, 13),
  ('Web Development Project 2', 'web-dev-project-2', 'Update this with your actual project details', '/img/portfolio-4.jpg', 'web-development', false, 14),
  ('WordPress Project 1', 'wordpress-project-1', 'Update this with your actual project details', '/img/portfolio-5.jpg', 'wordpress', false, 15),
  ('WordPress Project 2', 'wordpress-project-2', 'Update this with your actual project details', '/img/portfolio-6.jpg', 'wordpress', false, 16);

-- ============================================
-- EXPERIENCE
-- ============================================
insert into experience (company, position, start_date, end_date, is_current, description, location, sort_order) values
  (
    'Pentagon International Limited',
    'Sr. WordPress Developer',
    '2022-07-01',
    '2023-11-30',
    false,
    'Senior WordPress developer building custom themes and plugins for enterprise clients.',
    'Rangs Nasim Square, 275/D, Suite #C12, Lift Level-11, Rd No. 27, Dhaka 1207',
    1
  ),
  (
    'Azmaain Corporation',
    'WordPress Developer',
    '2020-03-01',
    '2022-06-15',
    false,
    'WordPress development, theme customization, and client project delivery.',
    'Rangs Nasim Square, 275/D, Suite #C12, Lift Level-11, Rd No. 27, Dhaka 1207',
    2
  ),
  (
    'Enigma IT Solution',
    'Jr. Web Designer',
    '2019-01-06',
    '2020-02-28',
    false,
    'Web design and front-end development for various client projects.',
    '85/A Eskaton Palace, New Eskaton Road, Banglamotor, Dhaka-1000',
    3
  );

-- ============================================
-- EDUCATION
-- ============================================
insert into education (institution, degree, field, start_year, end_year, sort_order) values
  ('Daffodil International University', 'Bachelor of Science (B.Sc)', 'Computer Science & Engineering', 2014, 2019, 1),
  ('Queen''s School & College', 'Higher Secondary Certificate (HSC)', 'Science', 2012, 2014, 2),
  ('K.B.M. Collegiate High School', 'Secondary School Certificate (SSC)', 'Science', 2010, 2012, 3);

-- ============================================
-- SERVICES
-- ============================================
insert into services (title, description, icon, sort_order) values
  ('Graphics Design', 'Creating compelling brand identities, logos, and visual assets that communicate your brand story effectively.', 'palette', 1),
  ('Web Design', 'Designing modern, responsive, and user-friendly websites with clean aesthetics and intuitive navigation.', 'monitor', 2),
  ('Web Development', 'Building robust, scalable web applications using modern frameworks and best coding practices.', 'code', 3),
  ('WordPress', 'Custom WordPress themes, plugins, and full website solutions tailored to your business needs.', 'layout', 4);

-- ============================================
-- SOCIAL LINKS
-- ============================================
insert into social_links (platform, url, icon, sort_order) values
  ('Instagram', 'https://www.instagram.com/mr.bappy2/', 'instagram', 1),
  ('YouTube', 'https://www.youtube.com/@LotsofLaugh-lol', 'youtube', 2),
  ('GitHub', 'https://github.com/Md-Moklesar-Rahman-Bappy', 'github', 3),
  ('LinkedIn', 'https://www.linkedin.com/in/md-moklasar-rahman-bappy', 'linkedin', 4);
