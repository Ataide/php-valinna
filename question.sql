-- --------------------------------------------------------

--
-- Estrutura da tabela `questions`
--

CREATE TABLE questions (
	id serial PRIMARY KEY,
	client VARCHAR ( 50 ),
	advisor VARCHAR ( 50 ),
	brokker VARCHAR ( 50 ),
	asset VARCHAR( 50 ),
	product VARCHAR ( 50 ),
	ideal_amount MONEY,
	amount MONEY,
  question VARCHAR ( 255 ),
  comment VARCHAR ( 255 ),
  answer VARCHAR ( 255 )
);