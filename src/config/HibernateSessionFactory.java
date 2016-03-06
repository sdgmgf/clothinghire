package config;
import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.hibernate.cfg.Configuration;
/**
 * �������Hibernate�е�Session�����ļ�
 * �ڴ����ļ��ж�ȡhibernate.cfg.xml�����ļ�
 * @author Administrator
 *
 */
public class HibernateSessionFactory {
	private static String CONFIG_FILE_LOCATION = "/config/hibernate.cfg.xml";
	private static final ThreadLocal<Session> threadLocal = new ThreadLocal<Session>();
	private static Configuration configuration = new Configuration();
	private static org.hibernate.SessionFactory sessionFactory;
	
	static{
		try{
			configuration.configure(CONFIG_FILE_LOCATION); //��ȡ�����ļ�hibernate.cfg.xml
			
			sessionFactory = configuration.buildSessionFactory();
		}catch(Exception e)
		{
			e.printStackTrace();
		}
	}
	
	private HibernateSessionFactory()
	{
		
	}
	//��ȡsession����
	public static Session getSession() throws HibernateException
	{
		Session session = (Session) threadLocal.get();
		if(session == null || !session.isOpen())
		{
			if(sessionFactory == null)
				rebuildSessionFactory();
			session = (sessionFactory != null)  ? sessionFactory.openSession() : null;
			threadLocal.set(session);
		}
		return session;
		
	}
	//������������
	public static void rebuildSessionFactory()
	{
		try{
			configuration.configure(CONFIG_FILE_LOCATION);
			sessionFactory = configuration.buildSessionFactory();
		}catch(Exception e)
		{
			e.printStackTrace();
		}
	}
	//�ر�session�ķ���
	public static void closeSession() throws HibernateException
	{
		Session session = (Session) threadLocal.get();
		threadLocal.set(null);
		if(session != null)
			session.close();
	}
	
	public static org.hibernate.SessionFactory getSessionFactory()
	{
		return sessionFactory;
	}
	
	public static Configuration getConfiguration()
	{
		return configuration;
	}
}
