package com.yqq.hibernate.clothinghire.dao;

import org.hibernate.Session;
import org.hibernate.Query;

import java.util.*;

import com.yqq.struts2.clothinghire.entity.User;
import config.HibernateSessionFactory;
/**
 * �û�ʵ���DAO
 * @author Administrator
 *
 */
public class UserDAO {
	
	public int login(String username,String passwd)
	{
		Session session = HibernateSessionFactory.getSession();
		try{
			Query query = session.createQuery("from User u where u.userName=?");
			System.out.println("username=" + username);
			query.setString(0, username);
			List list = query.list();
			System.out.println("List�Ƿ�Ϊnull��" + (null == list));
			if(null == list || 0 == list.size())
				return -1; //�û���������
			Iterator it = list.iterator();
			User user = (User) it.next();
			if(!passwd.equals(user.getPasswd()))
				return -2; //���벻��ȷ
			return user.getUserId(); //�����û�IDֵ
			
		}catch(Exception e)
		{
			e.printStackTrace();
			return 0; //�쳣����0
		}finally{
			HibernateSessionFactory.closeSession();
		}
		//return 0;
	}

}
