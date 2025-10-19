CREATE TABLE track (
  id SERIAL,
  title character varying(100) NOT NULL,
  gpx text NOT NULL,
  userid bigint NOT NULL,
  creation_date timestamp without time zone NOT NULL DEFAULT current_timestamp,
  update_date timestamp without time zone NOT NULL DEFAULT current_timestamp,
  min_lat DOUBLE PRECISION NOT NULL,
  max_lat DOUBLE PRECISION NOT NULL,
  min_lng DOUBLE PRECISION NOT NULL,
  max_lng DOUBLE PRECISION NOT NULL,
  is_active boolean NOT NULL DEFAULT true
) ;


