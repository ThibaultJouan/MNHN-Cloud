import java.util.*;
import java.io.*;
import java.math.*;

class Player {
	int playerId;
	int factoryCount;
	int linkCount;
	int nowTurn;
	Edge edges[];
    HashMap<Integer, Factory> factoryMap = new HashMap<Integer,Factory>();
    ArrayList<Troop> troopList = new ArrayList<Troop>();
    ArrayList<Bomb> bombList = new ArrayList<Bomb>();
    HashMap<Integer, Bomb> enBombMap = new HashMap<Integer, Bomb>();
	Scanner in = new Scanner(System.in);
	int bombCount=0;
	Random rand = new Random();

    public static void main(String args[]){
    	try{
    		new Player();
    	}catch(Exception e){
    		e.printStackTrace();
    	}
    }
	public Player()throws Exception{
		firstInput();
        firstProcess();
        while (true) {
            loopInput();
            if(nowTurn==0)firstTurnProcess();
            String ans = mainProcess();
            System.out.println(ans.substring(0,ans.length()-1));
        }
	}

    public void firstInput(){
    	factoryCount = in.nextInt();
        linkCount = in.nextInt();
        edges = new Edge[linkCount];
        for (int i = 0; i < linkCount; i++) {
        	edges[i] = new Edge();
            edges[i].factory1 = in.nextInt();
            edges[i].factory2 = in.nextInt();
            edges[i].distance = in.nextInt();
        }
    }

    void firstProcess(){
    	for(int i=0; i<factoryCount;i++){
        	factoryMap.put(i, new Factory(i));
        }
        for(Factory f: factoryMap.values()){
        	f.generateConnection();
        }

        for(Factory f: factoryMap.values()){
        	for(Connection c: f.connectionList){
        		int totalDist = 0;
        		int fromId = f.id;

	      	 	totalDist += calcShortestRouteDist(fromId,c.factory.id, c.dist-totalDist);
	      	 	c.nearRouteDist = totalDist;
        	}
        }

        for(Factory f: factoryMap.values()){
        	f.sortConnection();
        	System.err.print("id:"+f.id);
        	for(Connection c: f.connectionList){
        		System.err.print(" ["+c.factory.id+","+c.nearRouteDist+"]");
        	}
        	debug("");
        }
    }


    void loopInput(){
    	int entityCount = in.nextInt();
    	troopList.clear();
    	bombList.clear();
    	for(Bomb b: enBombMap.values()){
    		b.exist = 0;
    	}
        for (int i = 0; i < entityCount; i++) {
        	Entity tmp = new Entity();
            int entityId = tmp.id = in.nextInt();
            String entityType = in.next();
            tmp.arg1 = in.nextInt();
            tmp.arg2 = in.nextInt();
            tmp.arg3 = in.nextInt();
            tmp.arg4 = in.nextInt();
            tmp.arg5 = in.nextInt();
            switch(entityType.charAt(0)){
            case 'F':
            	Factory factory = factoryMap.get(entityId);
            	factory.inputState(tmp);
            	break;
            case 'T':
            	Troop troop = new Troop(tmp);
            	troopList.add(troop);
            	break;
            case 'B':
            	Bomb bomb = new Bomb(tmp);
            	bombList.add(bomb);
            	if(bomb.owner == -1 && enBombMap.containsKey(bomb.id)==false){
            		enBombMap.put(bomb.id, bomb);

            	}
            	if( enBombMap.containsKey(bomb.id)){
            		enBombMap.get(bomb.id).exist = 1;
            	}
            	break;
            }
        }
    }

    public void firstTurnProcess(){

    	for(Factory factory: factoryMap.values()){
    		if(factory.owner==1){
    			if(factory.id%2==0){
    				playerId = 0;
    			}
    			else{
    				playerId = 1;
    			}
       		}
    	}

    	for(Factory f: factoryMap.values()){
    		if(f.owner==1)continue;
    		if(f.owner==-1){
    			f.nearEnemy = 1;
    			continue;
    		}
			f.calcNearEnemy();
			f.calcNearMyFactory();
			if(f.nearEnemyDist < f.nearMyFactoryDist)f.nearEnemy = 1;
			else if(f.nearEnemyDist == f.nearMyFactoryDist && f.id%2!=playerId)f.nearEnemy=1;
		}
    }

	String mainProcess()throws Exception{
        TreeMap<Double,Factory> factoryTree = new TreeMap<Double, Factory>();
        ArrayList<Factory> tmp = new ArrayList<Factory>();
        ArrayList<Factory> tmp2 = new ArrayList<Factory>();
        String ans = "WAIT;";

        beforeProcess();

        calcTree(factoryTree);
        for(Factory f:factoryTree.values())tmp.add(f);for(int i=0;i<factoryTree.size();i++)tmp2.add(tmp.get(factoryTree.size()-i-1));

		System.err.println("myCyb:");for(Troop t: troopList){if(t.owner!=1) continue;System.err.print("to:"+t.toFactoryId +" cN:"+t.cybNum+" rT:"+t.remainTime);}
        debug("");System.err.print("help2:"); for(Factory f: tmp2)System.err.print("["+f.id+","+f.calcHelp2()+"] "); debug("");

    	ans += decideBomb();
    	ans += escapeBombProcess();
        for(Factory f: tmp2){
        	String str = f.calcToOutput();
        	if(str.charAt(str.length()-1)=='v'){
        		ans += str.substring(0, str.length()-1);
        		break;
        	}
        	else{
        		ans += str;
        	}
        }
        debug("inc");
       	ans += incProcess();
       	debug("");debug("enProd0");
       	ans += enProd0Process();
       	debug("");debug("amari");
       	ans += amariProcess();

    	nowTurn++;
        return ans;
	}

	public void beforeProcess(){
		for(Factory f: factoryMap.values()){
			f.gatherComeTroop();
			f.sortComeTroop();
			f.gatherBomb();
			f.sortConnectionProd();
			f.judgeNextTurnOwn();
			f.calcNearEnemy();
			f.calcNearMyFactory();
			f.calcAveMyFactory();
			f.nearestEnemy = 0;
			f.justBombed = 0;
			if(f.waitCount!=0)f.production = 0;
		}

		debug("JustBombed");
		ArrayList<Bomb> removeBomb = new ArrayList<Bomb>();
    	for(Bomb bomb: enBombMap.values()){
    		if(bomb.exist == 0){
    			removeBomb.add(bomb);
    			continue;
    		}
    		bomb.count++;
        	for(Factory f: factoryMap.values()){
        		for(Connection c: f.connectionList){
        			if(c.factory.id == bomb.fromFactoryId){
        				if(c.dist == bomb.count){
        					f.justBombed = 1;
        					System.err.print(" id:"+f.id+" JB:"+f.justBombed);
        				}
        			}
        		}
        	}
    	}
    	for(Bomb b:removeBomb){
    		enBombMap.remove(b.id);
    	}
    	debug("");

		int min = 999;
		int minId =-1;
		for(Factory f: factoryMap.values()){
			if(f.owner==1&&min>f.nearEnemyDist){
				min = f.nearEnemyDist;
				minId = f.id;
			}
		}
		for(Factory f: factoryMap.values()){
			if(f.owner==1&&min==f.nearEnemyDist){
				f.nearestEnemy = 1;
			}
		}
	}
	public void calcTree(TreeMap<Double, Factory> tree){

    	 for(Factory f: factoryMap.values()){
    		 double score = 0;
    		 int subDist = f.nearMyFactoryDist - f.nearEnemyDist;
    		 int helpNum = f.calcHelp2();/
    		 switch(f.owner){
    		 case 1:
    			 if(f.oriProd==0)continue;
    			 else if(f.nearEnemy==1)continue;
    			 else{
    				 score += helpNum;
    				 if(helpNum>=1)score += f.oriProd*5;
    				 if(f.waitCount!=0)score*=2;
    			 }
    			 break;
    		 case 0:
    			 if(f.oriProd==0)continue;

    		 	if(f.nearEnemy==1)continue;

    			 score += -f.nearMyFactoryDist;
    			 score += f.oriProd*5;
    			 score += -f.cybNum;
    			 break;
    		 case -1:

    		 	int nowTurn = 1;
				int nowCybNum = -f.cybNum;
				int nowOwner = f.owner;
				int endTurn = 0;
				int bombCount = f.waitCount+1;

				for(ComeTroop c: f.comeTroopList)endTurn = c.remainTime;
				for(Bomb b: f.comeBombList){if(b.remainTime>endTurn){endTurn = b.remainTime;}}
				if(endTurn < f.nearMyFactoryDist+1)endTurn = f.nearMyFactoryDist+1;
				if(3>endTurn){endTurn = 3;}

				while(nowTurn <= endTurn){
					bombCount--;
					int arriveMe = 0;
					int arriveEn = 0;
					for(ComeTroop c: f.comeTroopList){
						if(c.owner== 1&& c.remainTime==nowTurn)arriveMe += c.cybNum;
						if(c.owner==-1&& c.remainTime==nowTurn)arriveEn += c.cybNum;
					}
					for(Connection c: f.connectionList){
						if(c.nearRouteDist>3)continue;
						if(c.factory.owner==1||c.factory.id==f.id || c.factory.id==0)continue;
						for(ComeTroop ec:c.factory.comeTroopList){
							if(ec.owner==-1 && c.nearRouteDist + ec.remainTime == nowTurn-1 /*&& nowTurn <= 4*/){


									arriveEn += ec.cybNum;


							}
						}
						if(c.nearRouteDist != nowTurn-1)continue;
						if(c.factory.owner==-1){

								arriveEn += c.factory.cybNum;

						}
						if(c.factory.owner == 1){
							arriveMe += c.factory.cybNum;
						}
					}
					int tmpa = arriveEn;
					nowCybNum += arriveMe-arriveEn;

					for(Bomb b: f.comeBombList){
						if(b.remainTime != nowTurn)continue;
						bombCount = 5;
						if(nowOwner==1){if(nowCybNum<=20){nowCybNum-=10;if(nowCybNum < 0)nowCybNum = 0;}else nowCybNum = (nowCybNum+1)/2;}
						else if(nowOwner == -1){if(nowCybNum>=-20){nowCybNum+=10;if(nowCybNum > 0)nowCybNum = 0;}else nowCybNum = (nowCybNum+1)/2;}
					}
					if(bombCount > 0)nowCybNum += f.production*nowOwner;
					else nowCybNum += f.oriProd*nowOwner;
					if(nowCybNum<0)nowOwner=-1;
					else if(nowCybNum>0 && nowOwner != 0)nowOwner = 1;
					nowTurn++;
				}


				if(nowCybNum>0 ){
					if(f.nearMyFactoryDist >= 3)continue;
	    			if(f.nearEnemy==1 || f.id==0) continue;
	    		}
	    		else {
					if(f.nearEnemy==1 || f.id==0) continue;
	    		}
    			 if(f.oriProd==0)continue;
    			 score += -f.nearMyFactoryDist;//newarと比較すべき
    			 score += f.oriProd*5;
    			 score += -f.cybNum;
    			 if(f.waitCount!=0)score*=2;
    			 break;
    		 }
    		 score += f.id*0.001;//rand.nextDouble()*0.001;
    		 tree.put(score, f);
    	 }
    }
    public String incProcess(){
        TreeMap<Double,Factory> factoryTree = new TreeMap<Double, Factory>();
        ArrayList<Factory> tmp = new ArrayList<Factory>();
        ArrayList<Factory> tmp2 = new ArrayList<Factory>();
    	String ans = "WAIT;";

        calcIncTree(factoryTree);
        for(Factory f:factoryTree.values())tmp.add(f); for(int i=0;i<factoryTree.size();i++)tmp2.add(tmp.get(factoryTree.size()-i-1));

        for(Factory f: factoryMap.values())f.incHelpTarget = 0;
        for(Factory f: tmp2){
        	if(f.owner != 1)continue;
        	ans += f.calcInc();
        }
        for(Factory f: tmp2){
        	if(f.id==0)continue;
        	String str = f.calcToIncOutput();
        	ans += str;
        }

        return ans;
    }
    public void calcIncTree(TreeMap<Double, Factory> tree){
    	for(Factory f: factoryMap.values()){
    		if(f.owner == -1)continue;
    		if(f.nearEnemy==1 && f.id!=0)continue;
    		if(f.oriProd == 3)continue;
    		 double score = 0;
    		 int tmpOwner = f.owner;
    		 if(f.nextTurnOwn == 1)tmpOwner  =1;
    		 switch(tmpOwner){
    		 case 1:
    		 	for(Connection c: f.connectionList){
    		 		if(c.factory.owner!=1 || c.factory.production<=0)continue;
    				System.err.print("id:"+f.id+"cid:"+c.factory.id+" cdist:"+c.dist+" cnrDist:"+c.nearRouteDist);
    		 		score -= c.nearRouteDist;
    		 		score -=(10-f.cybNum);
    		 		score += f.oriProd*0.1;
    		 		score += f.id*0.001;
    		 		break;
    		 	}
    			 break;
    		 case 0:
    		 	for(Connection c: f.connectionList){
    		 		if(c.factory.owner!=1 || c.factory.production<=0)continue;
    				System.err.print("id:"+f.id+"cid:"+c.factory.id+" cdist:"+c.dist+" cnrDist:"+c.nearRouteDist);
    		 		score -= c.nearRouteDist;
    		 		score -=10+f.cybNum;
    		 		score += f.oriProd*0.1;
    		 		score += f.id*0.001;
    		 		break;
    		 	}
    		 	//score-=99999;
    			 break;
    		 }
    		 debug(" score:"+score);
    		// score += rand.nextDouble()*0.001;
    		 tree.put(score, f);
    	 }
    }
    public String enProd0Process(){
 		TreeMap<Double,Factory> factoryTree = new TreeMap<Double, Factory>();
        ArrayList<Factory> tmp = new ArrayList<Factory>();
        ArrayList<Factory> tmp2 = new ArrayList<Factory>();
        String ans = "WAIT;";

        calcEnProd0Tree(factoryTree);//各工場のhelp優先度を決めて、それ順に並び替える
        for(Factory f:factoryTree.values())tmp.add(f);for(int i=0;i<factoryTree.size();i++)tmp2.add(tmp.get(factoryTree.size()-i-1));//昇順を降順に並び替える

        for(Factory f: tmp2){
        	ans += f.calcToEnProd0Output();
        }
        return ans;
    }
    public void calcEnProd0Tree(TreeMap<Double, Factory> tree){
		//資源奪取、INC、防衛と様々な意味合いがあるので、それぞれの専用calcTree処理するのはどう？
		 for(Factory f: factoryMap.values()){
		 	if(f.owner!=-1)continue;
			 if(f.oriProd!=0)continue;
			 double score = 0;

			 if(f.nearEnemy==1 || f.id==0) continue;
			 score += -f.aveMyFactoryDist;//newarと比較すべき
			 score += f.production*5;
			 score += -f.cybNum;

			 score += f.id*0.001;//rand.nextDouble()*0.001;
			 tree.put(score, f);
		 }
    }
    public String amariProcess(){
    	String ret = "WAIT;";
        for(Factory f: factoryMap.values()){
        	if(f.owner != 1)continue;
        	ret += f.amariOutput();
        }
        return ret;
    }
    public String escapeBombProcess(){
    	String ret = "WAIT;";
        for(Factory f: factoryMap.values()){
        	if(f.owner != 1 || f.justBombed==0)continue;
        	ret += f.escapeBombOutput();
        }
        return ret;
    }

	public void afterProcess(){

	}
	//ボム処理
	public String decideBomb(){
		String ret = "WAIT;";
		for(Factory f: factoryMap.values()){
			if(f.owner!=1)continue;
			if(f.bombChaseSend!=0){
				f.cybNum--;
				ret += "MOVE "+f.id+" "+(f.bombChaseSend-1)+" 1;";
				f.bombChaseSend=0;
			}
		}
		if(bombCount>=2)return ret;
		int min = 999;
		int targetId=-1;
		int exeId = -1;
        for(Factory f: factoryMap.values()){
        	if(f.owner!= 1 )continue;
        	if(f.cybNum<=0)continue;

        	String tmp[] = f.findBombTartget().split(" ");
        	if(tmp.length==2){
        		int dist = Integer.parseInt(tmp[0]);
        		int tId = Integer.parseInt(tmp[1]);
        		if(min > dist){
        			min = dist;
        			targetId = tId;
        			exeId = f.id;
        		}
        	}
        }
        if(targetId==-1)return "";
        bombCount++;
        factoryMap.get(targetId).bombed = 1;
        factoryMap.get(exeId).bombChaseSend = targetId+1;
        return ret + "BOMB "+exeId+" "+targetId+";";
	}

	int tabCount = 0;
	int ffff = 0;
	int amariFlag = 0;

	public int saiki(Factory f, int toId, int totalDist, int minDist){
		if(ffff==1 && amariFlag == 1 && (f.id==1||f.id==1||f.id==0 || f.id==0)){
			for(int i=0; i<tabCount;i++)System.err.print("|   ");
			debug("nowId:"+f.id+" tDist:"+totalDist+" mDist:"+minDist);
		}
		if(f.id == toId)return totalDist;
		int flag=0;
		for(Connection c: f.connectionList){
			if(c.dist + totalDist <= minDist){
				tabCount++;
				int tmp = saiki(c.factory, toId, totalDist+c.dist+1,minDist);
				tabCount--;
				if( tmp<=minDist ){
					flag = 1;
					minDist = tmp;
				}
			}
		}
		if(flag == 0)return 9999;
		return minDist;
	}
	public int calcShortestRouteDist(int fromId, int toId, int dist){
		Factory fromF = factoryMap.get(fromId);
		Factory toF = factoryMap.get(toId);
		int minDist = dist;

		for(Connection c: fromF.connectionList){
			int tmp = saiki(c.factory, toId, c.dist,minDist);
			if(tmp <= minDist){
				minDist = tmp;
			}
		}
		return minDist;
	}
	public int calcShortestRoute(int fromId, int toId, int dist){
		Factory fromF = factoryMap.get(fromId);
		Factory toF = factoryMap.get(toId);
		int minDist = dist;
		int minId = toId;

		for(Connection c: fromF.connectionList){
			if(fromId==11 && toId==0)ffff=1;
			int tmp = saiki(c.factory, toId, c.dist,minDist);
			ffff=0;
			if(tmp <= minDist){
				minDist = tmp;
				minId = c.factory.id;
			}
		}
		return minId;
	}

    class Edge{
    	int distance;
    	int factory1;
    	int factory2;
    }
    class ComeTroop{
		int owner;
		int remainTime;
		int cybNum;
		int flag;
		public ComeTroop(int ao, int ar, int ac){
			owner = ao;
			remainTime = ar;
			cybNum = ac;
		}
	}
	class Connection{
		int dist;
		int nearRouteDist;
		boolean used;
		Factory factory;
		int intervalCount;
		public Connection(int ad, Factory af){
			dist = ad;
			factory = af;
		}
	}


	class Factory{
		int id;int owner;int cybNum;int production;int waitCount;
		int oriProd;
		int helpNum;
		int helpedTurn;
		int aveMyFactoryDist;
		int nearMyFactoryDist;
		int nearEnemyDist;
		int bombed;
		int incHelpTarget;
		int dengerNum;
		int nearEnemy;
		int nearestEnemy;
		int nextTurnOwn ;
		int justBombed;
		int mightBombeCount;
		int attackTargetId;
		int bombChaseSend;
		int reserveCount;
		ArrayList<Connection> connectionList = new ArrayList<Connection>();
		ArrayList<Connection> connectionSortProdList = new ArrayList<Connection>();
		ArrayList<ComeTroop> comeTroopList = new ArrayList<ComeTroop>();
		ArrayList<Bomb> comeBombList = new ArrayList<Bomb>();


		public Factory(int ai){
			id = ai;
		}

		public void generateConnection(){
			for(int i=0; i<linkCount;i++){
				int targetId = -1;
				int dist = edges[i].distance;
				if(edges[i].factory1 == id){
					targetId = edges[i].factory2;
				}
				if(edges[i].factory2 == id){
					targetId = edges[i].factory1;
				}
				if(targetId != -1){
					Connection c = new Connection(dist, factoryMap.get(targetId));
					connectionList.add(c);

				}
			}
		}
		//この工場が持っているコネクションをdistの昇順にsortする
		public void sortConnection(){
			Connection c[] = new Connection[connectionList.size()];
			int i=0;
			int len = connectionList.size();
			for(Connection ct: connectionList){
				c[i] = ct;i++;
			}
			for(i=0;i<len;i++){
				for(int j=0; j<len-i-1;j++){
					if(c[j].nearRouteDist > c[j+1].nearRouteDist){
						Connection tmp = c[j];
						c[j] = c[j+1];
						c[j+1]=tmp;
					}
				}
			}
			connectionList.clear();;

			for(i=0;i<len;i++){
				connectionList.add(c[i]);
			}
		}
		//この工場が持っているコネクションをdistの昇順にsortする
		public void sortConnectionWithHelp2(){
			Connection c[] = new Connection[connectionList.size()];
			int i=0;
			int len = connectionList.size();
			for(Connection ct: connectionList){
				c[i] = ct;i++;
			}
			for(i=0;i<len;i++){
				for(int j=0; j<len-i-1;j++){
					if(c[j].factory.calcHelp2() < c[j+1].factory.calcHelp2()){
						Connection tmp = c[j];
						c[j] = c[j+1];
						c[j+1]=tmp;
					}
				}
			}
			connectionList.clear();;

			for(i=0;i<len;i++){
				connectionList.add(c[i]);
			}
		}
		//工場の入力に対する状態の更新
		public void inputState(Entity ae){
			owner = ae.arg1;
			cybNum = ae.arg2;
			production = ae.arg3;
			waitCount = ae.arg4;
			oriProd = production;
		}

		public void gatherComeTroop(){
			comeTroopList.clear();
			for(Troop t: troopList){
				if(t.toFactoryId == this.id){
					comeTroopList.add(new ComeTroop(t.owner, t.remainTime, t.cybNum));
				}
			}
		}

		public void sortComeTroop(){
			ComeTroop c[] = new ComeTroop[comeTroopList.size()];
			int i=0;
			int len = comeTroopList.size();
			for(ComeTroop ct: comeTroopList){
				c[i] = ct;i++;
			}
			for(i=0;i<len;i++){
				for(int j=0; j<len-i-1;j++){
					if(c[j].remainTime > c[j+1].remainTime){
						ComeTroop tmp = c[j];
						c[j] = c[j+1];
						c[j+1]=tmp;
					}
				}
			}
			comeTroopList.clear();;
			for(i=0;i<len;i++){
				comeTroopList.add(c[i]);
			}
		}
		public void sortConnectionProd(){
			Connection c[] = new Connection[connectionList.size()];
			int i=0;
			int len = connectionList.size();
			for(Connection ct: connectionList){
				c[i] = ct;i++;
			}
			for(i=0;i<len;i++){
				for(int j=0; j<len-i-1;j++){
					if(c[j].factory.oriProd < c[j+1].factory.oriProd){
						Connection tmp = c[j];
						c[j] = c[j+1];
						c[j+1]=tmp;
					}
				}
			}
			connectionSortProdList.clear();;
			for(i=0;i<len;i++){
				connectionSortProdList.add(c[i]);
			}
		}
		public void gatherBomb(){
			comeBombList.clear();
			for(Bomb b: bombList){
				if(b.toFactoryId == this.id){
					comeBombList.add(b);
				}
			}
		}

		public void calcNearEnemy(){
			int min = 9999;
			for(Connection c: connectionList){
				if(c.factory.owner==-1 && min>c.nearRouteDist){
					min = c.nearRouteDist;
				}
			}
			nearEnemyDist = min;
		}

		public void calcNearMyFactory(){
			int min = 9999;
			for(Connection c: connectionList){
				if(c.factory.owner==1 && min>c.nearRouteDist){
					min = c.nearRouteDist;
				}
			}
			nearMyFactoryDist = min;
		}
		//接続されたすべての工場の平均distをaveMyFactoryに保存するだけ
		public void calcAveMyFactory(){
			double ave = 0;
			int num = 0;
			for(Connection c: connectionList){
				if(c.factory.owner==1){
					ave += c.nearRouteDist;
					num++;
				}
			}
			if(num==0)aveMyFactoryDist=0;
			else{
				aveMyFactoryDist = (int)ave/num+1;
			}
		}
		public void judgeNextTurnOwn(){
			nextTurnOwn = 0;
			if(owner!=0)return;
			int tmpSum = 0;
			for(ComeTroop c: comeTroopList){
				if(c.remainTime!=1)return;
				if(c.owner == 1){
					tmpSum += c.cybNum;
				}
				else if(c.owner==-1){
					tmpSum -= c.cybNum;
				}
			}
			if(tmpSum > 0){
				if(cybNum < tmpSum){
					nextTurnOwn = 1;
				}
			}
		}

		public int calcHelp2(){
			int nowTurn = 1;
			int nowCybNum = cybNum;
			int nowOwner = owner;
			if(owner == -1)nowCybNum*=-1;
			int endTurn = 0;
			int bombCount = waitCount;//前は+1だった

			for(ComeTroop c: comeTroopList)if(c.owner==-1&&endTurn<c.remainTime)endTurn = c.remainTime;
			for(Bomb b: comeBombList){if(b.remainTime>endTurn){endTurn = b.remainTime;}}
			if(endTurn < nearMyFactoryDist+1)endTurn = nearMyFactoryDist+1;
			if(3>endTurn){endTurn = 3;}//endTurnは重要なので考察すべき


			while(nowTurn <= endTurn){
				bombCount--;
				int arriveMe = 0;
				int arriveEn = 0;
				for(ComeTroop c: comeTroopList){
					if(c.owner== 1&& c.remainTime==nowTurn)arriveMe += c.cybNum;
					if(c.owner==-1&& c.remainTime==nowTurn)arriveEn += c.cybNum;
				}
				int tmpa = arriveEn;
				if(oriProd>1){
					for(Connection c: connectionList){
						if(c.nearRouteDist>nearMyFactoryDist)continue;//前は３
						if(c.factory.owner==1||c.factory.id==id /*|| c.factory.id==0*/)continue;
						for(ComeTroop ec:c.factory.comeTroopList){
							if(ec.owner==-1 && c.nearRouteDist + ec.remainTime == nowTurn-1 /*&& nowTurn <= 4*/){
								if(/*oriProd>=3||*/c.dist==1){
								//debug("troop,cybNum:"+ec.cybNum+" rtime:"+ec.remainTime);
									arriveEn += ec.cybNum;
								//}
								}
							}
						}
						if(c.nearRouteDist!=c.factory.nearMyFactoryDist || c.nearRouteDist != nowTurn-1)continue;
						if(c.factory.owner==-1){
							//if(nearestEnemy==1){
								arriveEn += c.factory.cybNum;
							//}
						}
						if(c.factory.owner == 1){
							//arriveMe += c.factory.cybNum;
						}
					}
				}

				if(nowOwner == 0){
					int downPoint = arriveMe - arriveEn;
					nowCybNum -= zchi(downPoint);
					if(nowCybNum<0){
						if(downPoint>0){
							nowCybNum*=-1;
							nowOwner = 1;
						}
						else if(downPoint < 0){
							nowOwner = -1;
						}
					}
				}
				else{
					nowCybNum += arriveMe-arriveEn;
				}

				for(Bomb b: comeBombList){
					if(b.remainTime != nowTurn)continue;
					bombCount = 5;
					if(nowOwner==1){
						if(nowCybNum<=20){
							nowCybNum-=10;
							if(nowCybNum < 0)nowCybNum = 0;
						}
						else nowCybNum = (nowCybNum+1)/2;
					}
					else if(nowOwner == -1){if(nowCybNum>=-20){nowCybNum+=10;if(nowCybNum > 0)nowCybNum = 0;}else nowCybNum = (nowCybNum+1)/2;}
				}

				if(nowCybNum<0)nowOwner=-1;
				else if(nowCybNum>0 && nowOwner != 0)nowOwner = 1;
				if(bombCount > 0)nowCybNum += 0*nowOwner;
				else nowCybNum += oriProd*nowOwner;

				nowTurn++;
			}
			if(nowOwner!=1)return zchi(nowCybNum)+1;
			else return 0;
		}

		//この工場が対象となる命令をすべて決める
		public String calcToOutput(){
			String ret = "WAIT;";
			int helpN = calcHelp2();;

			if(helpN>0){
				System.err.print(" id:"+id);
				for(Connection c: connectionList){
					if(c.factory.owner!= 1 || c.factory.id==id )continue;//敵や自分自身からは援助を求めない
					int toId = calcShortestRoute(c.factory.id,id,c.dist);
					c.factory.attackTargetId = toId;
					int cyN = c.factory.calcGiveHelp();
					System.err.print(" cid:"+c.factory.id+" cyN:"+cyN);

					if(c.factory.justBombed==0){
						if(cyN<=0)continue;
					}else{
						if(c.factory.cybNum<=0)continue;//期待できる増援が0未満なら、このコネクションは諦める
						if(cyN<=0)cyN = c.factory.cybNum;
					}
					if(isBombedNoSend(c.factory, toId)==true)continue;

					ret += "MOVE "+c.factory.id+" "+toId+" ";
					if(cyN<=helpN){
						ret += ""+cyN;c.factory.cybNum -= cyN;helpN-=cyN;
					}
					else{
						ret += ""+helpN;c.factory.cybNum-=helpN;helpN = 0;
					}
					ret += ";";
					if(helpN==0)break;
				}
				debug("");
			}
			return ret;
		}

		//未来を予想して、何人までなら派遣できるかを返す
		public int calcGiveHelp(){
			int nowTurn = 1;
			int nowCybNum = cybNum;
			int nowOwner = owner;
			int endTurn = 0;
			int bombCount = waitCount;//前は+1だった
			int minCybNum = nowCybNum;

			for(ComeTroop c: comeTroopList){if(endTurn<c.remainTime)endTurn = c.remainTime;}
			if(endTurn < nearMyFactoryDist+1 && nearMyFactoryDist<100)endTurn = nearMyFactoryDist+1;
			if(endTurn < 3)endTurn = 3;

			Factory nearEnemyFactory = null;
			int min = 9999;
			for(Connection c: connectionList){
				if(c.factory.owner==-1 && c.dist < min){
					min = c.dist;
					nearEnemyFactory = c.factory;
				}
			}
			if(inc0Flag == 1 && nearEnemyFactory!=null){
				for(ComeTroop c: nearEnemyFactory.comeTroopList){if(endTurn<c.remainTime)endTurn = c.remainTime;}
				//debug("endTurn:"+endTurn);
			}
			if(incFlag==1)System.err.println("nt:"+nowTurn+" endT:"+endTurn+ " ncN:"+nowCybNum);
			while(nowTurn <= endTurn){
				bombCount--;
				int arriveMe = 0;
				int arriveEn = 0;
				for(ComeTroop c: comeTroopList){
					if(c.owner==1&& c.remainTime==nowTurn)arriveMe += c.cybNum;
					if(c.owner==-1&& c.remainTime==nowTurn)arriveEn += c.cybNum;
				}
				if(oriProd>1 || inc0Flag==1){
					for(Connection c: connectionList){
						double tmpa = 1;
						//if(c.factory.id == attackTargetId)tmpa = 0.5;
						if(c.nearRouteDist>nearMyFactoryDist)continue;
						if(c.factory.owner==1||c.factory.id==id /*|| c.factory.id==0*/)continue;
						for(ComeTroop ec:c.factory.comeTroopList){
							if(ec.owner==-1 && c.nearRouteDist + ec.remainTime == nowTurn-1 /*&& nowTurn <= 4*/){
								if(/*oriProd>=3 ||*/inc0Flag == 1 || (c.factory.owner==-1&&c.dist==1)){
									arriveEn += ec.cybNum*tmpa;;
								}
							}
						}
						if(c.nearRouteDist!=c.factory.nearMyFactoryDist || c.nearRouteDist != nowTurn-1)continue;//新追加ルール
						if(c.factory.owner==-1){
							//if(nearestEnemy==1){
								arriveEn += c.factory.cybNum*tmpa;

							//}
						}
						if(c.factory.owner == 1){
							//arriveMe += c.factory.cybNum;
						}
					}
				}

				nowCybNum += arriveMe-arriveEn;

				for(Bomb b: comeBombList){
					if(b.remainTime == nowTurn){
						bombCount = 5;
						if(nowOwner==1){if(nowCybNum<=20){nowCybNum-=10;if(nowCybNum < 0)nowCybNum = 0;}else nowCybNum = (nowCybNum+1)/2;
						}
						else if(nowOwner == -1){if(nowCybNum>=-20){nowCybNum+=10;if(nowCybNum > 0)nowCybNum = 0;}else nowCybNum = (nowCybNum+1)/2;
						}
					}
				}

				if(nowCybNum<0)nowOwner=-1;
				else if(nowCybNum>0 && nowOwner != 0)nowOwner = 1;
				if(bombCount > 0){
					nowCybNum += 0*nowOwner;
				}
				else{
					nowCybNum += oriProd*nowOwner;
				}
				if(incFlag==1)System.err.println("nt:"+nowTurn+" ncN:"+nowCybNum+" nOwn:"+nowOwner+" nProd:"+oriProd+" ariEn:"+arriveEn);

				//if(inc0Flag==1)debug("nowCybNum:"+nowCybNum);
				if(minCybNum > nowCybNum)minCybNum = nowCybNum;
				nowTurn++;
			}
			if(minCybNum<0)return -1;
			else return minCybNum;
		}

		public boolean isBombedNoSend(Factory f, int toId){
			int toDist = 0;
			for(Connection c2: f.connectionList){
				if(c2.factory.id == toId)toDist = c2.dist;
			}
			Factory toFactory = factoryMap.get(toId);
			int bombedFlag = 0;
			for(Bomb bomb: enBombMap.values()){
				for(Connection c2: toFactory.connectionList){
					if(c2.factory.id==bomb.fromFactoryId){
						if(bomb.count+toDist == c2.dist)bombedFlag = 1;
					}
				}
			}
			if(bombedFlag == 1)return true;
			else return false;
		}
		public String calcToIncOutput(){
			String ret = "WAIT;";
			int helpN = 0;
			int comeHelp = 0;
			for(ComeTroop c: comeTroopList){
				if(c.owner == 1)comeHelp += c.cybNum;
			}
			if(cybNum + oriProd*10 + comeHelp >=30)return ret;//20を30にしてみる
			incHelpTarget = helpN = (3-oriProd)*10-cybNum - comeHelp;
			System.err.println("id:"+id+","+"cybNum:"+cybNum+" oriProd:"+oriProd+" helpN:"+helpN);

			if(helpN>0){
				ArrayList<Integer> existRouteId = new ArrayList<Integer>();
				for(Connection c: connectionList){
					if(c.factory.owner!= 1 || c.factory.id==id )continue;//敵や自分自身からは援助を求めない
					if(c.factory.justBombed==0 && c.factory.incHelpTarget>0)continue;//敵や自分自身からは援助を求めない

					int toId = calcShortestRoute(c.factory.id,id,c.dist);
					c.factory.attackTargetId = toId;
					int cyN = c.factory.calcGiveHelp() ;
					System.err.print(" cic:"+c.factory.id+" cyN:"+cyN);
					if(c.factory.oriProd!=10 )cyN -= (3-c.factory.production)*10;
					if(c.factory.justBombed==0){
						if(cyN<=0)continue;
					}else{
						if(c.factory.cybNum<=0)continue;//期待できる増援が0未満なら、このコネクションは諦める
						if(cyN<=0)cyN = c.factory.cybNum;
					}

					int allToDist = calcShortestRouteDist(c.factory.id,id,c.dist);
					int helpN2 = helpN ;
					int recovery = 0;
					int nowOwner=owner;
					int nowProd = oriProd;
					int nowCybNum = cybNum;
					for(int i=1;i<=allToDist;i++){
						int arriveMe = 0;
						int arriveEn = 0;
						for(ComeTroop ct: comeTroopList){
							if(ct.remainTime!=i)continue;//タイミング考察の余地あり
							if(ct.owner==1)arriveMe+=ct.cybNum;
							if(ct.owner==-1)arriveEn += ct.cybNum;
						}
						if(nowOwner==1){
							nowCybNum += arriveMe - arriveEn;
						}
						if(nowOwner==0){
							int downPoint = arriveMe - arriveEn;
							nowCybNum -= zchi(downPoint);
							if(nowCybNum<0 && downPoint>0){
								nowOwner = 1;
								nowCybNum *= -1;
							}
							if(nowCybNum<0 && downPoint<0){
								nowOwner=-1;
							}
						}
						if(nowCybNum>=10&&nowProd<3){
							nowCybNum -=10;
							nowProd++;
						}
						if(i<=waitCount)recovery += 0;
						else {
							if(nowOwner==1){
								recovery += nowProd;
								nowCybNum += nowProd;
							}
						}
					}
					/*if(owner == 1)*/helpN2 -= recovery;
					if(helpN2<=0)continue;
					if(isBombedNoSend(c.factory, toId)==true)continue;

					System.err.print(" helpN2:"+helpN2);
					int existF = 0;
					for(int tmpe: existRouteId){
						if(tmpe==toId)existF = 1;
					}
					if(existF == 1){
						existRouteId.add(c.factory.id);
						continue;
					}

					ret += "MOVE "+c.factory.id+" "+toId+" ";
					if(cyN<=helpN2){
						ret += ""+cyN;
						c.factory.cybNum -= cyN;
						helpN-=cyN;
					}
					else{
						ret += ""+helpN2;
						c.factory.cybNum-=helpN2;
						helpN = 0;
					}
					ret += ";";
					existRouteId.add(c.factory.id);
				}
				debug("");
			}
			return ret;
		}

		//この工場が対象となる命令をすべて決める
		public String calcToEnProd0Output(){
			String ret = "WAIT;";
			int helpN = calcHelp2();

			if(helpN>0){
				System.err.print(" id:"+id);
				ArrayList<Integer> existRouteId = new ArrayList<Integer>();
				for(Connection c: connectionList){
					if(c.factory.owner!= 1 || c.factory.id==id )continue;//敵や自分自身からは援助を求めない
					if(c.factory.justBombed==0&&c.factory.incHelpTarget != 0 )continue;//敵や自分自身からは援助を求めない
					int toId = calcShortestRoute(c.factory.id,id,c.dist);
					c.factory.attackTargetId = toId;
					int cyN = c.factory.calcGiveHelp();

					System.err.print(" cid:"+c.factory.id+" cyN:"+cyN);
					if(c.factory.justBombed==0){
						if(cyN<=0)continue;
					}else{
						if(c.factory.cybNum<=0)continue;//期待できる増援が0未満なら、このコネクションは諦める
						if(cyN<=0)cyN = c.factory.cybNum;
					}

					if(isBombedNoSend(c.factory,toId)==true)continue;

					int existF = 0;
					for(int tmpe: existRouteId){
						if(tmpe==toId)existF = 1;
					}
					if(existF == 1){
						existRouteId.add(c.factory.id);
						continue;
					}

					ret += "MOVE "+c.factory.id+" "+toId+" ";
					if(cyN<=helpN){
						ret += ""+cyN;c.factory.cybNum -= cyN;helpN-=cyN;
					}
					else{
						ret += ""+helpN;c.factory.cybNum-=helpN;helpN = 0;
					}
					existRouteId.add(c.factory.id);
					ret += ";";
					if(helpN==0)break;
				}
				debug("");
			}

			return ret;
		}
		public String amariOutput(){
			String ret = "WAIT;";
			if(nearEnemy==1 ) return ret;
			if(cybNum <= 0 || (justBombed==0&&oriProd<3) || id==0)return ret;
			int dist0 = 0;
			for(Connection c: connectionList){
				if(c.factory.id==0)dist0 = c.dist;
			}
			int toId = calcShortestRoute(id,0,dist0);
			attackTargetId = toId;
			int cyN = calcGiveHelp() ;
			if(cyN<=0)return ret;
			//amariFlag = 1;

			int min = dist0;
			int minId = toId;
			if(justBombed==1/*&&oriProd<3*/){
				for(Connection c: connectionList){
					if(c.factory.nearEnemy==0 && min>c.dist){
						if(isBombedNoSend(this, c.factory.id)==false){
							min = c.dist;
							minId = c.factory.id;
						}
					}
				}
				toId = minId;
			}
			if(isBombedNoSend(this, toId)==true)return ret;

			amariFlag = 0;
			ret += "MOVE "+id+" "+toId+" "+cyN+";";
			System.err.print("["+id+"]"+cyN+",");
			return ret;
		}
		public String escapeBombOutput(){
			String ret = "WAIT;";
			if(nearEnemy==1 ) return ret;
			if(cybNum <= 0 || (justBombed==0&&oriProd<3) || id==0)return ret;


			int min = 999;
			int minId = -1;
			for(Connection c: connectionList){
				if((c.factory.id==0||c.factory.nearEnemy==0) && min>c.dist){
					if(isBombedNoSend(this, c.factory.id)==false){
						min = c.dist;
						minId = c.factory.id;
					}
				}
			}

			if(minId != -1){
				ret += "MOVE "+id+" "+minId+" "+cybNum+";";
				System.err.print("["+id+"]"+cybNum+",");
				cybNum = 0;
			}
			return ret;
		}


		String findBombTartget(){
			String ret = "a";//ボム１ターンに２回打てるようにする

			int min = 9999;
			int max = -999;
			int maxId = -1;
			int minId = -1;
			Connection maxC = null;
			for(Connection c: connectionList){
				Factory tmpFac = c.factory;
				if(tmpFac.nearEnemy==0 && tmpFac.owner==0 && tmpFac.cybNum >= 8 && tmpFac.bombed==0){
					if(max < tmpFac.cybNum){
						max = tmpFac.cybNum;
						maxId = tmpFac.id;
						maxC = c;
					}
				}
			}
			/*
			if(maxId!=-1&& maxC.dist <= maxC.nearRouteDist){
				Bomb bo = new Bomb();
		    	bo.owner=1;
		    	bo.fromFactoryId=id;
		    	bo.toFactoryId = maxC.factory.id;
		    	bo.remainTime = maxC.dist+1;
		    	bo.count=0;
		    	bo.exist=1;
				maxC.factory.comeBombList.add(bo);
				return -max+" "+maxId;
			}*/


			min = 9999;
			minId = -1;
			for(Connection c: connectionList){
				if(c.factory.owner!=1 &&c.factory.bombed==0&&c.factory.production==3 && min>c.dist){
					if(c.factory.owner==0 ){
						if(c.factory.nearEnemy==0)continue;
		        		int sum = 0;
		        		for(ComeTroop c2: c.factory.comeTroopList){
		        			if(c2.owner==-1){
		        				sum += c2.cybNum;
		        			}
		        		}
		        		if(sum<c.factory.cybNum)continue;
		        	}
					min = c.dist;
					minId = c.factory.id;
				}
			}

			if(minId !=-1 && min >= 5+nowTurn && nowTurn < 5)return "";
			if(minId!= -1){
				return min+" "+minId;
			}

			min = 9999;
			minId = -1;
			for(Connection c: connectionList){
				if(c.factory.owner!=1 &&c.factory.bombed==0&&c.factory.production==2 && min>c.dist){
					if(c.factory.owner==0 ){
						if(c.factory.nearEnemy==0)continue;
		        		int sum = 0;
		        		for(ComeTroop c2: c.factory.comeTroopList){
		        			if(c2.owner==-1){
		        				sum += c2.cybNum;
		        			}
		        		}
		        		if(sum<c.factory.cybNum)continue;
		        	}
					min = c.dist;
					minId = c.factory.id;
				}
			}
			if(minId !=-1 && min >= 5+nowTurn && nowTurn < 5)return "";
			if(minId!= -1){
				return min+" "+minId;
			}
			return ret;
		}

		int inc0Flag = 0;
		int incFlag = 0;
		public String calcInc(){
			String ret = "";
			if(id==0)inc0Flag = 1;
			debug("id:"+id+" incFlag0:"+inc0Flag);
			while(cybNum >=10){
				cybNum-=10;
				oriProd++;
				production++;
				incFlag = 1;
				debug(" id:"+id+" cN:"+cybNum+" oriProd"+oriProd + " cgh:"+calcGiveHelp());
				incFlag = 0;
				int tmp = 10;
				if(id==0){

					tmp=30;
				}
				if(cybNum+10>=tmp &&calcGiveHelp() >= 0&& oriProd <4 && justBombed==0){
					ret += "INC "+id+";";
				}
				else{
					cybNum+=10;
					oriProd--;
					production--;
					break;
				}
				//cybNum -=10;
				//oriProd++;
				//production++;
			}
			inc0Flag = 0;
			debug("id:"+id+" incFlag0:"+inc0Flag);
			return ret;
		}

	}

    class Troop{
    	int id;
    	int owner;
    	int fromFactoryId;
    	int toFactoryId;
    	int cybNum;
    	int remainTime;
    	public Troop(Entity ae){
    		id = ae.id;
    		owner = ae.arg1;
    		fromFactoryId = ae.arg2;
    		toFactoryId = ae.arg3;
    		cybNum = ae.arg4;
    		remainTime = ae.arg5;
    	}
    }
    class Bomb{
    	int id;
    	int owner;
    	int fromFactoryId;
    	int toFactoryId;
    	int remainTime;
    	int count;
    	int exist;
    	public Bomb(){

    	}
    	public Bomb(Entity ae){
    		id = ae.id;
    		owner = ae.arg1;
    		fromFactoryId = ae.arg2;
    		toFactoryId = ae.arg3;
    		remainTime = ae.arg4;
    	}
    }
    class Entity{
    	int id;
    	int arg1;
    	int arg2;
    	int arg3;
    	int arg4;
    	int arg5;
    	Entity(){}
    }

    public int zchi(int a){
    	if(a>=0)return a;
    	else return -a;
    }
    void debug(String str){
    	System.err.println(str);
    }
}<Paste>
