package com.yqq.struts2.clothinghire.action;

import com.opensymphony.xwork2.ActionSupport;

import com.yqq.hibernate.clothinghire.dao.UserDAO;
import com.yqq.struts2.clothinghire.entity.User;
public class LoginAction extends ActionSupport { 
	/*private String userName;
	private String passwd;
	
	public String getUsername()
	{
		return userName;
	}
	public void setUsername(String username)
	{
		this.userName = username;
	}
	
	public String getPassword()
	{
		return passwd;
	}
	public void setPassword(String password)
	{
		this.passwd = password;
	}*/
	private User user;
	public User getUser()
	{
		return user;
	}
	public void setUser(User user)
	{
		this.user = user;
	}
	
	public String execute()
	{
		UserDAO dao = new UserDAO();
		int result = dao.login(user.getUserName(), user.getPasswd());
		System.out.println("µÇÂ¼½á¹ûÏÔÊ¾:" + result);
		if(result > 0)
			return SUCCESS;
		else
			return INPUT;
	}
}
