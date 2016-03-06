package com.yqq.struts2.clothinghire.entity;

public class User {
	private Integer userId;
	private String userName;
	private String passwd;
	
	//无参构造器
	public User()
	{
		
	}
	//全参构造器
	public User(Integer userId,String userName,String passwd)
	{
		this.userId = userId;
		this.userName = userName;
		this.passwd = passwd;
	}
	
	public Integer getUserId()
	{
		return userId;
	}
	public void setUserId(Integer userId)
	{
		this.userId = userId;
	}
	
	public String getUserName()
	{
		return userName;
	}
	public void setUserName(String userName)
	{
		this.userName = userName;
	}
	
	public String getPasswd()
	{
		return passwd;
	}
	public void setPasswd(String passwd)
	{
		this.passwd = passwd;
	}

}
