
/*                          Tipo de comida                          */
insert into ADMI_TIPO_COMIDA(DESCRIPCION_TIPO_COMIDA,ESTADO,USR_CREACION,FE_CREACION) values('VARIOS','ACTIVO','kbaque',sysdate());
insert into ADMI_TIPO_COMIDA(DESCRIPCION_TIPO_COMIDA,ESTADO,USR_CREACION,FE_CREACION) values('COMIDA RAPIDA','ACTIVO','kbaque',sysdate());
/*                           Tipo de Rol                           */
insert into ADMI_TIPO_ROL(DESCRIPCION_TIPO_ROL,ESTADO,USR_CREACION,FE_CREACION) values('CLIENTE','ACTIVO','kbaque',sysdate());
insert into ADMI_TIPO_ROL(DESCRIPCION_TIPO_ROL,ESTADO,USR_CREACION,FE_CREACION) values('RESTAURANTE','ACTIVO','kbaque',sysdate());
insert into ADMI_TIPO_ROL(DESCRIPCION_TIPO_ROL,ESTADO,USR_CREACION,FE_CREACION) values('ADMINISTRADOR','ACTIVO','kbaque',sysdate());
insert into ADMI_TIPO_ROL(DESCRIPCION_TIPO_ROL,ESTADO,USR_CREACION,FE_CREACION) values('VENDEDOR','ACTIVO','kbaque',sysdate());
/*                       Tipo Cliente Puntaje                       */
insert into ADMI_TIPO_CLIENTE_PUNTAJE(DESCRIPCION,VALOR,ESTADO,USR_CREACION,FE_CREACION) values('CLIENTE','CLIENTE','ACTIVO','kbaque',sysdate());
/*                            Parametros                            */
insert into ADMI_PARAMETRO(DESCRIPCION,VALOR1,VALOR2,VALOR3,ESTADO,USR_CREACION,FE_CREACION) values('CANTIDAD_DISTANCIA','MOVIL','SUCURSAL','5','ACTIVO','kbaque',sysdate());
commit;