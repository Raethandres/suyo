--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.5
-- Dumped by pg_dump version 10.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: postgres; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE postgres IS 'default administrative connection database';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: componente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE componente (
    id integer NOT NULL,
    n integer NOT NULL
);


ALTER TABLE componente OWNER TO postgres;

--
-- Name: componente_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE componente_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE componente_id_seq OWNER TO postgres;

--
-- Name: componente_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE componente_id_seq OWNED BY componente.id;


--
-- Name: pelota; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE pelota (
    it integer,
    id_it integer NOT NULL,
    cant integer,
    id_co integer
);


ALTER TABLE pelota OWNER TO postgres;

--
-- Name: pelota_id_it_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pelota_id_it_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE pelota_id_it_seq OWNER TO postgres;

--
-- Name: pelota_id_it_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pelota_id_it_seq OWNED BY pelota.id_it;


--
-- Name: componente id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY componente ALTER COLUMN id SET DEFAULT nextval('componente_id_seq'::regclass);


--
-- Name: pelota id_it; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pelota ALTER COLUMN id_it SET DEFAULT nextval('pelota_id_it_seq'::regclass);


--
-- Data for Name: componente; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY componente (id, n) FROM stdin;
\.


--
-- Data for Name: pelota; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pelota (it, id_it, cant, id_co) FROM stdin;
\.


--
-- Name: componente_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('componente_id_seq', 3, true);


--
-- Name: pelota_id_it_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('pelota_id_it_seq', 6, true);


--
-- Name: componente componente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY componente
    ADD CONSTRAINT componente_pkey PRIMARY KEY (n);


--
-- Name: pelota pelota_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pelota
    ADD CONSTRAINT pelota_pkey PRIMARY KEY (id_it);


--
-- Name: pelota pelota_id_co_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pelota
    ADD CONSTRAINT pelota_id_co_fkey FOREIGN KEY (id_co) REFERENCES componente(n) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

