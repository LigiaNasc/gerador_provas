 --Assuntos para Português
INSERT INTO assuntos (nome, disciplina_id) VALUES
('Interpretação de Texto', 1),
('Ortografia', 1),
('Gramática', 1);

-- Assuntos para Inglês
INSERT INTO assuntos (nome, disciplina_id) VALUES
('Verbo To Be', 2),
('Simple Present', 2),
('Vocabulário Básico', 2);

-- Assuntos para História
INSERT INTO assuntos (nome, disciplina_id) VALUES
('Idade Média', 8),
('Revolução Francesa', 8),
('Brasil Colônia', 8);

-- Assuntos para Geografia
INSERT INTO assuntos (nome, disciplina_id) VALUES
('Climas do Mundo', 9),
('Formações Geológicas', 9),
('Geopolítica', 9);

-- Assuntos para Matemática
INSERT INTO assuntos (nome, disciplina_id) VALUES
('Funções', 13),
('Geometria', 13),
('Probabilidade', 13);

-- Agora sim: Inserir as Questões!

-- Questões de Português
INSERT INTO questoes (enunciado, disciplina_id, assunto_id, professor_id) VALUES
('Leia o texto e responda: Qual é a ideia principal apresentada?', 1, 1, 1),
('Assinale a alternativa com a grafia correta.', 1, 2, 1),
('Identifique o sujeito na seguinte oração: "O menino correu para a escola."', 1, 3, 1);

-- Questões de Inglês
INSERT INTO questoes (enunciado, disciplina_id, assunto_id, professor_id) VALUES
('Complete: I ___ a student.', 2, 4, 1),
('Forme uma frase afirmativa no Simple Present com o verbo "to like".', 2, 5, 1),
('Traduza para o inglês: "Eu gosto de estudar."', 2, 6, 1);

-- Questões de História
INSERT INTO questoes (enunciado, disciplina_id, assunto_id, professor_id) VALUES
('Explique o papel da Igreja Católica na Idade Média.', 8, 7, 1),
('Quais foram as principais causas da Revolução Francesa?', 8, 8, 1),
('Descreva a economia do Brasil durante o período colonial.', 8, 9, 1);

-- Questões de Geografia
INSERT INTO questoes (enunciado, disciplina_id, assunto_id, professor_id) VALUES
('Quais são os principais tipos de clima do mundo?', 9, 10, 1),
('Defina "placas tectônicas".', 9, 11, 1),
('Explique o conceito de globalização.', 9, 12, 1);

-- Questões de Matemática
INSERT INTO questoes (enunciado, disciplina_id, assunto_id, professor_id) VALUES
('Dada a função f(x) = 2x + 5, calcule f(3).', 13, 13, 1),
('Calcule a área de um triângulo com base 8 cm e altura 5 cm.', 13, 14, 1),
('Qual a probabilidade de sair "cara" em uma moeda?', 13, 15, 1);

-- E só agora: Inserir as Alternativas!

-- Alternativas para as Questões (de 1 a 15)
INSERT INTO alternativas (questao_id, texto, correta) VALUES
(1, 'O objetivo principal do texto.', TRUE),
(1, 'A descrição detalhada dos personagens.', FALSE),
(1, 'O tempo e local da narrativa.', FALSE),
(1, 'A biografia do autor.', FALSE),

(2, 'Exceção', TRUE),
(2, 'Excessão', FALSE),
(2, 'Exceçãon', FALSE),
(2, 'Escessão', FALSE),

(3, 'O menino', TRUE),
(3, 'correu', FALSE),
(3, 'para a escola', FALSE),
(3, 'nenhuma das anteriores', FALSE),

(4, 'am', TRUE),
(4, 'are', FALSE),
(4, 'is', FALSE),
(4, 'be', FALSE),

(5, 'She likes pizza.', TRUE),
(5, 'She like pizza.', FALSE),
(5, 'She liking pizza.', FALSE),
(5, 'She liked pizza.', FALSE),

(6, 'I like to study.', TRUE),
(6, 'I likes study.', FALSE),
(6, 'I study like.', FALSE),
(6, 'Study I like.', FALSE),

(7, 'Foi uma instituição poderosa e influente.', TRUE),
(7, 'Não teve influência política.', FALSE),
(7, 'Era independente dos reinos.', FALSE),
(7, 'Teve pouca participação na sociedade.', FALSE),

(8, 'Desigualdade social e crise econômica.', TRUE),
(8, 'Descoberta da América.', FALSE),
(8, 'Invenção da imprensa.', FALSE),
(8, 'Ascensão do Império Romano.', FALSE),

(9, 'Baseada na agricultura e mineração.', TRUE),
(9, 'Industrialização intensa.', FALSE),
(9, 'Tecnologia avançada.', FALSE),
(9, 'Economia baseada no petróleo.', FALSE),

(10, 'Tropical, Polar, Temperado.', TRUE),
(10, 'Desértico, Ártico, Vulcânico.', FALSE),
(10, 'Urbano, Rural, Industrial.', FALSE),
(10, 'Marítimo, Continental, Tropical.', FALSE),

(11, 'Grandes blocos de rocha da crosta terrestre.', TRUE),
(11, 'Massas de água subterrâneas.', FALSE),
(11, 'Correntes de vento.', FALSE),
(11, 'Erosão do solo.', FALSE),

(12, 'Relações de poder entre países.', TRUE),
(12, 'Movimentos sísmicos.', FALSE),
(12, 'Fenômenos climáticos.', FALSE),
(12, 'Ciclos naturais da Terra.', FALSE),

(13, '11', TRUE),
(13, '8', FALSE),
(13, '10', FALSE),
(13, '12', FALSE),

(14, '20 cm²', TRUE),
(14, '40 cm²', FALSE),
(14, '30 cm²', FALSE),
(14, '15 cm²', FALSE),

(15, '50%', TRUE),
(15, '25%', FALSE),
(15, '75%', FALSE),
(15, '100%', FALSE);
